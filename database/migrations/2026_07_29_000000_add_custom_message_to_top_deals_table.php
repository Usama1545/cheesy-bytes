<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('top_deals', function (Blueprint $table) {
            $table->string('custom_message', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::table('top_deals', function (Blueprint $table) {
            $table->dropColumn('custom_message');
        });
    }
};
