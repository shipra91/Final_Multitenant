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
        Schema::table('tbl_staff', function (Blueprint $table) {
            $table->String('middle_name')->nullable()->after('name');
            $table->String('last_name')->after('middle_name');
            $table->uuid('id_blood_group')->foreign('id_blood_group')->references('id')->on('tbl_blood_group')->onDelete('cascade')->nullable()->change();
            $table->uuid('id_designation')->foreign('id_designation')->references('id')->on('tbl_designations')->onDelete('cascade')->nullable()->change();
            $table->uuid('id_department')->foreign('id_department')->references('id')->on('tbl_department')->onDelete('cascade')->nullable()->change();
            $table->uuid('id_staff_subcategory')->foreign('id_staff_subcategory')->references('id')->on('tbl_staff_sub_categories')->onDelete('cascade')->nullable()->change();
            $table->String('duration_employment')->nullable()->change();
            $table->uuid('id_nationality')->foreign('id_nationality')->references('id')->on('tbl_nationality')->onDelete('cascade')->nullable()->change();
            $table->uuid('id_religion')->foreign('id_religion')->references('id')->on('tbl_religion')->onDelete('cascade')->nullable()->change();
            $table->uuid('id_caste_category')->foreign('id_caste_category')->references('id')->on('tbl_categories')->onDelete('cascade')->nullable()->change();
            $table->string('aadhaar_no')->nullable()->nullable()->change();
            $table->string('pancard_no')->nullable()->nullable()->change();
            $table->string('pf_uan_no')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_staff', function (Blueprint $table) {
            $table->dropColumn('middle_name');
            $table->dropColumn('last_name');
            $table->dropColumn('id_blood_group');
            $table->dropColumn('id_designation');
            $table->dropColumn('id_department');
            $table->dropColumn('id_staff_subcategory');
            $table->dropColumn('duration_employment');
            $table->dropColumn('id_nationality');
            $table->dropColumn('id_religion');
            $table->dropColumn('id_caste_category');
            $table->dropColumn('aadhaar_no');
            $table->dropColumn('pancard_no');
            $table->dropColumn('pf_uan_no');
        });
    }
};
