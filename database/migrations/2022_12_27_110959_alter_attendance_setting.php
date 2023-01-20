<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_attendance_settings', function (Blueprint $table) {
            $table->uuid('id_template')->foreign('id_template')->references('id')->on('tbl_sms_templates')->onDelete('cascade')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_attendance_settings', function (Blueprint $table) {
            $table->dropColumn('id_template');
        });
    }
};
