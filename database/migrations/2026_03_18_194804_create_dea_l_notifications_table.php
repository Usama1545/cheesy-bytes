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
        Schema::create('deal_notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('deal_id'); // NOT unsigned
            $table->foreign('deal_id')
                ->references('id')
                ->on('top_deals')
                ->cascadeOnDelete();
            $table->date('date')->nullable();              // for one-time
            $table->time('time');
            $table->string('repeat_type')->default('none'); // none | weekly
            $table->json('days')->nullable();               // ["mon","fri"]
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_sent_at')->nullable();
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
        Schema::dropIfExists('dea_l_notifications');
    }
};
