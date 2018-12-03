<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToMemberSubject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mef_member_subject', function (Blueprint $table) {
            $table->foreign('subject_id')->references('id')->on('mef_subjects')->onDelete('cascade');
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
        Schema::table('mef_member_subject', function (Blueprint $table) {
            $table->dropForeign('mef_member_subject_subject_id_foreign');
            $table->dropForeign('mef_member_subject_member_id_foreign');
        });
    }
}
