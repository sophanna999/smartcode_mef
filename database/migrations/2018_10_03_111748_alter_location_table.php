<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mef_locations', function (Blueprint $table) {
            $table->boolean('public')->default(0);
            $table->boolean('is_default')->default(0);
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
        Schema::table('mef_locations', function (Blueprint $table) {
            $table->dropColumn('public');
            $table->dropColumn('is_default');
            $table->dropColumn('department_id');
        });
    }
}
