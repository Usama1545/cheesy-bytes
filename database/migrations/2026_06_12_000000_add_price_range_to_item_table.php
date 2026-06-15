<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('item', function (Blueprint $table) {
            $table->decimal('max_price', 10, 2)->nullable()->after('price');
            $table->tinyInteger('is_price_range')->default(0)->after('max_price');
        });
    }

    public function down()
    {
        Schema::table('item', function (Blueprint $table) {
            $table->dropColumn(['max_price', 'is_price_range']);
        });
    }
};
