<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id'); //foreign key
            $table->bigInteger('invoice_number');
            $table->string('name');
            $table->text('description');            
            $table->float('rate');
            $table->float('time');
            $table->float('total');
            $table->integer('status')->default(0); // 0 for open 1 for closed
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
        Schema::dropIfExists('invoices');
    }
}
// task number can have multiple invoice numbers
//  how to generate invoice number 1000 first