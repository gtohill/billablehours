<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostinvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postinvoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id');  // foreign key from client table
            $table->bigInteger('invoice_number'); // invoice number from invoice table
            $table->float('amount'); //with out taxes                       
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
        Schema::dropIfExists('postinvoices');
    }
}
