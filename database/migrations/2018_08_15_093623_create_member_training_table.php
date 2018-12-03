<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mef_member_training', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->integer('training_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('mef_member_training', function (Blueprint $table) {
            $table->foreign('training_id')->references('id')->on('mef_trainings')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('mef_members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mef_member_training');
    }
}
