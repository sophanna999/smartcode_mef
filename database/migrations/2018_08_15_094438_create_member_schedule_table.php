<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mef_member_schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->integer('schedule_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('mef_member_schedule', function (Blueprint $table) {
            $table->foreign('member_id')->references('id')->on('mef_members')->onDelete('cascade');
            $table->foreign('schedule_id')->references('id')->on('mef_schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mef_member_schedule');
    }
}
