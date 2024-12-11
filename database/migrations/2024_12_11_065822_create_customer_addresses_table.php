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
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('session_id'); // To track guests
            $table->enum('address_type', ['carryout', 'delivery']);
            $table->string('state');
            $table->string('city')->nullable();
            $table->string('zip');
            $table->string('address')->nullable(); // For delivery only
            $table->date('date'); // Selected date for carryout or delivery
            $table->time('time'); // Selected time for carryout or delivery
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
        Schema::dropIfExists('customer_addresses');
    }
};
