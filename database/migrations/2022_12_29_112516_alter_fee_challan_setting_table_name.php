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
        Schema::table('tbl_fee_challan_setting', function (Blueprint $table) {
            $table->uuid('id_institution_bank_detail')->foreign('id_institution_bank_detail')->references('id')->on(' tbl_institution_bank_details')->onDelete('cascade')->after('id_template');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_fee_challan_setting', function (Blueprint $table) {
            $table->dropColumn('id_institution_bank_detail');
        });
    }
};
