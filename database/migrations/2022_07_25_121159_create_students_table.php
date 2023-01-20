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
        Schema::create('tbl_student', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_preadmission')->foreign('id_preadmission')->references('id')->on('tbl_preadmission')->onDelete('cascade');
            $table->String('name');
            $table->Date('date_of_birth');
            $table->uuid('id_gender')->foreign('id_gender')->references('id')->on('tbl_gender')->onDelete('cascade');
            $table->Integer('egenius_uid')->unique();
            $table->String('usn');
            $table->String('register_number');
            $table->Integer('roll_number');
            $table->Date('admission_date');
            $table->String('admission_number');
            $table->String('sats_number');
            $table->String('student_aadhaar_number');
            $table->uuid('id_nationality')->foreign('id_nationality')->references('id')->on('tbl_nationality')->onDelete('cascade'); 
            $table->uuid('id_religion')->foreign('id_religion')->references('id')->on('tbl_religion')->onDelete('cascade');
            $table->String('caste');
            $table->uuid('id_caste_category')->foreign('id_caste_category')->references('id')->on('tbl_categories')->onDelete('cascade');
            $table->String('mother_tongue');
            $table->uuid('id_blood_group')->foreign('id_blood_group')->references('id')->on('tbl_blood_group')->onDelete('cascade');
            $table->Text('address');
            $table->String('city');
            $table->String('area');
            $table->String('taluk');
            $table->String('district');
            $table->String('state');
            $table->String('country');
            $table->Integer('pincode');
            $table->String('father_name');
            $table->String('father_mobile_number');
            $table->String('father_aadhaar_number');
            $table->String('father_education');
            $table->String('father_profession');
            $table->String('father_email');
            $table->String('father_annual_income');
            $table->String('mother_name');
            $table->String('mother_mobile_number');
            $table->String('mother_aadhaar_number');
            $table->String('mother_education');
            $table->String('mother_profession');
            $table->String('mother_email');
            $table->String('mother_annual_income');
            $table->String('guardian_name');
            $table->String('guardian_aadhaar_no');
            $table->String('guardian_contact_no');
            $table->String('guardian_email');
            $table->String('guardian_relation');
            $table->String('guardian_address');
            $table->Enum('sms_for',['Father', 'Mother', 'Both']);
            $table->String('attachment_student_photo');
            $table->String('attachment_student_aadhaar');
            $table->String('attachment_father_aadhaar');
            $table->String('attachment_mother_aadhaar');
            $table->String('attachment_father_pancard');
            $table->String('attachment_mother_pancard');
            $table->String('attachment_previous_tc');
            $table->String('attachment_previous_study_certificate');
            $table->String('created_by')->nullable();
            $table->String('modified_by')->nullable();
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
        Schema::dropIfExists('tbl_student');
    }
};
