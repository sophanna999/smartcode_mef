<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mef_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('profileable_type');
            $table->string('profileable_id');
            $table->string('full_name');
            $table->string('latin_name');
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->string('avatar')->nullable();
            $table->string('position')->nullable();
            $table->string('company')->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mef_profiles');
    }
}
