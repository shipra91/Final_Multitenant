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
        Schema::table('tbl_create_fee_challans', function (Blueprint $table) {
            $table->uuid('id_challan_setting')->foreign('id_challan_setting')->references('id')->on(' tbl_create_fee_challans')->onDelete('cascade')->after('id_student');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_create_fee_challans', function (Blueprint $table) {
            $table->dropColumn('id_challan_setting');
        });
    }
};
