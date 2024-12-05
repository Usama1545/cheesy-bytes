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
        Schema::create('custom_pizza_sauces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('size_id');
            $table->string('name');
            $table->decimal('price', 8, 2); // Price for the sauce at this size
            $table->timestamps();

            // Foreign keys
            $table->foreign('size_id')->references('id')->on('custom_pizza_sizes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_pizza_sauces');
    }
};
