<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mef_schedules', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->datetime('time_in')->change();
            $table->datetime('time_out')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mef_schedules', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->time('time_in')->change();
            $table->time('time_out')->change();
        });
    }
}
