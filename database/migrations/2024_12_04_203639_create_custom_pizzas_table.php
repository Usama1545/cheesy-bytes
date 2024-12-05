<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_pizzas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('size_id'); // Size of the pizza
            $table->unsignedBigInteger('crust_id'); // Crust type of the pizza
            $table->json('sauce_ids');
            $table->decimal('base_price', 8, 2); // Base price for the custom pizza
            $table->timestamps();

            // Foreign keys
            $table->foreign('size_id')->references('id')->on('custom_pizza_sizes')->onDelete('cascade');
            $table->foreign('crust_id')->references('id')->on('custom_pizza_crusts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_pizzas');
    }
};
