<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mef_trainings', function ($table) {
            $table->string('custom_location')->after('location_id')->nullable();
            $table->integer('location_id')->nullable()->change();
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
            $table->dropColumn('custom_location');
            $table->integer('location_id')->nullable(false)->change();
        });
    }
}
