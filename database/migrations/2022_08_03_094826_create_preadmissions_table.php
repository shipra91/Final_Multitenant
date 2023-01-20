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
        Schema::create('tbl_preadmission', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->uuid('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->Integer('application_number');
            $table->String('name');
            $table->String('middle_name')->nullable();
            $table->String('last_name')->nullable();
            $table->uuid('id_standard')->foreign('id_standard')->references('id')->on('tbl_institution_standard')->onDelete('cascade');
            $table->Date('date_of_birth');
            $table->uuid('id_gender')->foreign('id_gender')->references('id')->on('tbl_gender')->onDelete('cascade');
            $table->String('student_aadhaar_number');
            $table->uuid('id_nationality')->foreign('id_nationality')->references('id')->on('tbl_nationality')->onDelete('cascade');
            $table->uuid('id_religion')->foreign('id_religion')->references('id')->on('tbl_religion')->onDelete('cascade');
            $table->String('caste');
            $table->uuid('id_caste_category')->foreign('id_caste_category')->references('id')->on('tbl_categories')->onDelete('cascade')->nullable();
            $table->String('mother_tongue')->nullable();
            $table->uuid('id_blood_group')->foreign('id_blood_group')->references('id')->on('tbl_blood_group')->onDelete('cascade')->nullable();
            $table->Text('address');
            $table->String('city')->nullable();
            $table->String('taluk');
            $table->String('district');
            $table->String('state')->nullable();
            $table->String('country')->nullable();
            $table->Integer('pincode');
            $table->String('post_office');
            $table->String('father_name');
            $table->String('father_middle_name')->nullable();
            $table->String('father_last_name')->nullable();
            $table->String('father_mobile_number');
            $table->String('father_aadhaar_number')->nullable();
            $table->String('father_education')->nullable();
            $table->String('father_profession')->nullable();
            $table->String('father_email')->nullable();
            $table->String('father_annual_income')->nullable();
            $table->String('mother_name');
            $table->String('mother_middle_name')->nullable();
            $table->String('mother_last_name')->nullable();
            $table->String('mother_mobile_number');
            $table->String('mother_aadhaar_number')->nullable();
            $table->String('mother_education')->nullable();
            $table->String('mother_profession')->nullable();
            $table->String('mother_email')->nullable();
            $table->String('mother_annual_income')->nullable();
            $table->String('guardian_name')->nullable();
            $table->String('guardian_middle_name')->nullable();
            $table->String('guardian_last_name')->nullable();
            $table->String('guardian_aadhaar_no')->nullable();
            $table->String('guardian_contact_no')->nullable();
            $table->String('guardian_email')->nullable();
            $table->String('guardian_relation')->nullable();
            $table->String('guardian_address')->nullable();
            $table->Enum('sms_for',['Father', 'Mother', 'Both']);
            $table->String('attachment_student_photo')->nullable();
            $table->String('attachment_student_aadhaar')->nullable();
            $table->String('attachment_father_aadhaar')->nullable();
            $table->String('attachment_mother_aadhaar')->nullable();
            $table->String('attachment_father_pancard')->nullable();
            $table->String('attachment_mother_pancard')->nullable();
            $table->String('attachment_previous_tc')->nullable();
            $table->String('attachment_previous_study_certificate')->nullable();
            $table->Enum('admitted', ['YES','NO']);
            $table->Enum('application_status', ['APPROVED','REJECTED','PENDING','CORRECTION_REQUEST']);
            $table->String('remarks')->nullable();
            $table->String('created_by')->nullable();
            $table->String('modified_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('tbl_preadmission');
    }
};
