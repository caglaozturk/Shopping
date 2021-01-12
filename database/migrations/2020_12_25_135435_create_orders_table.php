<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('cart_id')->unique();
            $table->decimal('order_price',10,4);
            $table->string('status', 30)->nullable();

            $table->string('fullname',50)->nullable();
            $table->string('address',200)->nullable();
            $table->string('phone_number',15)->nullable();
            $table->string('mobile_number',15)->nullable();
            $table->string('bank', 20);
            $table->string('installment')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
