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
            $table->enum('status', [
                'in_cart', // user still choose products
                'pending', //when user checkout order
                'paid', // user paid for order
                'delivered', //driver == user get his order
                'returned', //driver == user does not receive his order
                'cancelled' //user cancel order
            ]);
            $table->double('total')->nullable();
            $table->double('subtotal')->default(0);
            $table->double('fees')->default(0);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('address_id')
                ->constrained('addresses')
                ->onDelete('cascade');

            $table->foreignId('driver_id')
                ->nullable()
                ->constrained('drivers')
                ->onDelete('cascade');
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
