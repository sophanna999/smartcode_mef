<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mef_rooms', function (Blueprint $table) {
            $table->boolean('public')->default(0);
            $table->integer('department_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mef_rooms', function (Blueprint $table) {
            $table->dropColumn('public');
            $table->dropColumn('department_id');
        });
    }
}
