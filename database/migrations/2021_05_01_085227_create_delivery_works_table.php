<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_works', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boy_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->enum('status',['progress','delivered'])->default('progress');
            $table->foreign('boy_id')->references('id')->on('delivery_boys')->onDelete('SET NULL');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('SET NULL');
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
        Schema::dropIfExists('delivery_works');
    }
}
