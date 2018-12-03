<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutsideStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mef_outside_staffs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nationality')->nullable();
            $table->string('education')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('company_tel')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_website')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('mef_profile_attachements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id');
            $table->string('type');
            $table->string('no');
            $table->text('file');
            $table->boolean('status')->default(1);
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
        Schema::drop('mef_outside_staffs');
        Schema::drop('mef_profile_attachements');
    }
}
