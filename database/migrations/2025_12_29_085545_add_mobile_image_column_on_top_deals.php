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
        Schema::table('top_deals', function (Blueprint $table) {
            $table->string('web_image')->nullable();
            $table->string('mobile_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('top_deals', function (Blueprint $table) {
            $table->dropColumn('web_image');
            $table->dropColumn('mobile_image');
        });
    }
};
