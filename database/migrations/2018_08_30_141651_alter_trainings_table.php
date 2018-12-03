<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mef_trainings', function ($table) {
            $table->string('prefix')->after('id')->nullable();
            $table->integer('location_id')->unsigned();
            $table->integer('course_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mef_trainings', function ($table) {
            $table->dropColumn('prefix');
            $table->dropColumn('location_id');
            $table->dropColumn('course_id');
        });
    }
}
