<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pizza_toppings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('custom_pizza_id');
            $table->unsignedBigInteger('topping_id');
            $table->enum('position', ['left', 'right', 'full']); // Position of the topping
            $table->decimal('price', 8, 2); // Price for the topping
            $table->timestamps();

            // Foreign keys
            $table->foreign('custom_pizza_id')->references('id')->on('custom_pizzas')->onDelete('cascade');
            $table->foreign('topping_id')->references('id')->on('custom_pizza_toppings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pizza_toppings');
    }
};
