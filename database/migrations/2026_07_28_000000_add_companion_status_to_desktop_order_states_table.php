<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('desktop_order_states', function (Blueprint $table) {
            $table->string('printer_status')->nullable()->after('last_printed_order_id');
            $table->string('printer_name')->nullable()->after('printer_status');
            $table->string('buzzer_status')->nullable()->after('printer_name');
            $table->unsignedInteger('poll_interval_seconds')->nullable()->after('buzzer_status');
        });
    }

    public function down()
    {
        Schema::table('desktop_order_states', function (Blueprint $table) {
            $table->dropColumn(['printer_status', 'printer_name', 'buzzer_status', 'poll_interval_seconds']);
        });
    }
};
