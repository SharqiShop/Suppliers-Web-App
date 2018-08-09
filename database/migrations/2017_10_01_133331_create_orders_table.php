<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orderid');
            $table->integer('instock');
            $table->integer('outofstock');
            $table->string('status');
            $table->string('name');
            $table->string('phone');
            $table->integer('total');
            $table->integer('bag_count');
            $table->string('country');
            $table->string('city');
            $table->string('street_one');
            $table->string('payment_type');
            $table->string('email');
            $table->integer('weight');
            $table->date('date');
            $table->string('tracking_id');
            $table->string('shipment_time');
            $table->string('order_image');
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
        Schema::drop('orders');
    }
}
