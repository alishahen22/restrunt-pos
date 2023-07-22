<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('table_id');
            $table->integer('user_id');
            $table->decimal('total_price')->default(0);
            $table->decimal('total_recieved')->default(0);// total recieved from customer
            $table->decimal('change')->default(0);// change to customer
            $table->string('payment_type')->default(''); // cash or card
            $table->string('status')->default('unpaid'); //
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
        Schema::dropIfExists('sales');
    }
}
