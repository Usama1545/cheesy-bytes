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
        Schema::table('settings', function (Blueprint $table) {
            $table->decimal('point_per_dollar', 10, 2)->default(0)->nullable();
            $table->decimal('dollar_per_point', 10, 2)->default(0)->nullable();
            $table->integer('max_redeem_points')->default(0)->nullable();
            $table->integer('min_redeem_points')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('point_per_dollar');
            $table->dropColumn('dollar_per_point');
            $table->dropColumn('max_redeem_points');
            $table->dropColumn('min_redeem_points');
        });
    }
};
