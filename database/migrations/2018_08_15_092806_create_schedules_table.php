<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mef_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('training_id')->unsigned();
            $table->integer('subject_id')->unsigned()->nullable();
            $table->integer('room_id')->unsigned()->nullable();
            $table->text('custom_room')->nullable();
            $table->time('time_in');
            $table->time('time_out');
            $table->timestamps();
        });
        Schema::table('mef_schedules', function (Blueprint $table) {
            $table->foreign('training_id')->references('id')->on('mef_trainings')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('mef_subjects')->onDelete('set null');
            $table->foreign('room_id')->references('id')->on('mef_rooms')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mef_schedules');
    }
}
