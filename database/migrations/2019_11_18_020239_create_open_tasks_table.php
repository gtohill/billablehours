<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpenTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('open_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id'); // id is always tablename + id  or client_id
            $table->string('name');
            $table->text('description');            
            $table->boolean('status')->default(0);
            $table->float('time')->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('open_tasks');
    }
}
