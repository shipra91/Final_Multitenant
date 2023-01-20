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
        Schema::table('tbl_student', function (Blueprint $table) {
            $table->String('usn')->nullable()->change();
            $table->bigInteger('egenius_uid')->nullable()->change();
            $table->String('register_number')->nullable()->change();
            $table->String('roll_number')->nullable()->change();
            $table->date('admission_date')->nullable()->change();
            $table->String('admission_number')->nullable()->change();
            $table->String('sats_number')->nullable()->change();
            $table->String('student_aadhaar_number')->nullable()->change();
            $table->uuid('id_caste_category')->nullable()->change();
            $table->String('mother_tongue')->nullable()->change();
            $table->uuid('id_blood_group')->nullable()->change();
            $table->String('city')->nullable()->change();
            $table->dropColumn('area');
            $table->String('state')->nullable()->change();
            $table->String('country')->nullable()->change();
            $table->String('post_office')->after('pincode');
            $table->String('father_aadhaar_number')->nullable()->change();
            $table->String('father_education')->nullable()->change();
            $table->String('father_profession')->nullable()->change();
            $table->String('father_email')->nullable()->change();
            $table->String('father_annual_income')->nullable()->change();
            $table->String('mother_aadhaar_number')->nullable()->change();
            $table->String('mother_education')->nullable()->change();
            $table->String('mother_profession')->nullable()->change();
            $table->String('mother_email')->nullable()->change();
            $table->String('mother_annual_income')->nullable()->change();
            $table->String('guardian_name')->nullable()->change();
            $table->String('guardian_aadhaar_no')->nullable()->change();
            $table->String('guardian_contact_no')->nullable()->change();
            $table->String('guardian_email')->nullable()->change();
            $table->String('guardian_relation')->nullable()->change();
            $table->String('guardian_address')->nullable()->change();
            $table->String('attachment_student_photo')->nullable()->change();
            $table->String('attachment_student_aadhaar')->nullable()->change();
            $table->String('attachment_father_aadhaar')->nullable()->change();
            $table->String('attachment_mother_aadhaar')->nullable()->change();
            $table->String('attachment_father_pancard')->nullable()->change();
            $table->String('attachment_mother_pancard')->nullable()->change();
            $table->String('attachment_previous_tc')->nullable()->change();
            $table->String('attachment_previous_study_certificate')->nullable()->change();
            $table->softDeletes()->after('modified_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_student', function (Blueprint $table) {
            $table->dropColumn('usn');
            $table->dropColumn('egenius_uid');
            $table->dropColumn('register_number');
            $table->dropColumn('roll_number');
            $table->dropColumn('admission_date');
            $table->dropColumn('admission_number');
            $table->dropColumn('sats_number');
            $table->dropColumn('student_aadhaar_number');
            $table->dropColumn('id_caste_category');
            $table->dropColumn('mother_tongue');
            $table->dropColumn('id_blood_group');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('country');
            $table->dropColumn('post_office');
            $table->dropColumn('father_aadhaar_number');
            $table->dropColumn('father_education');
            $table->dropColumn('father_profession');
            $table->dropColumn('father_email');
            $table->dropColumn('father_annual_income');
            $table->dropColumn('mother_aadhaar_number');
            $table->dropColumn('mother_education');
            $table->dropColumn('mother_profession');
            $table->dropColumn('mother_email');
            $table->dropColumn('mother_annual_income');
            $table->dropColumn('guardian_name');
            $table->dropColumn('guardian_aadhaar_no');
            $table->dropColumn('guardian_contact_no');
            $table->dropColumn('guardian_email');
            $table->dropColumn('guardian_relation');
            $table->dropColumn('guardian_address');
            $table->dropColumn('attachment_student_photo');
            $table->dropColumn('attachment_student_aadhaar');
            $table->dropColumn('attachment_father_aadhaar');
            $table->dropColumn('attachment_mother_aadhaar');
            $table->dropColumn('attachment_father_pancard');
            $table->dropColumn('attachment_mother_pancard');
            $table->dropColumn('attachment_previous_tc');
            $table->dropColumn('attachment_previous_study_certificate');
            $table->dropColumn('deleted_at');
        });
    }
};
