<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mef_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(1);
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('code')->nullable();
            $table->string('name');
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
        Schema::drop('mef_rooms');
    }
}