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
        Schema::table('tbl_class_time_table_detail', function (Blueprint $table) {
            $table->dropColumn('id_staff');
            $table->string('id_staffs')->after('id_subject');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_class_time_table_detail', function (Blueprint $table) {
            $table->dropColumn('id_staff');
            $table->dropColumn('id_staffs');
        });
    }
};
