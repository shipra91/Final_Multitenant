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
        Schema::create('tbl_staff', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('employee_id')->nullable();
            $table->bigInteger('staff_uid')->unique();
            $table->uuid('id_gender')->foreign('id_gender')->references('id')->on('tbl_gender')->onDelete('cascade');
            $table->uuid('id_blood_group')->foreign('id_blood_group')->references('id')->on('tbl_blood_group')->onDelete('cascade');
            $table->uuid('id_designation')->foreign('id_designation')->references('id')->on('tbl_designations')->onDelete('cascade');
            $table->uuid('id_department')->foreign('id_department')->references('id')->on('tbl_department')->onDelete('cascade');
            $table->uuid('id_role')->foreign('id_role')->references('id')->on('tbl_role')->onDelete('cascade');
            $table->uuid('id_staff_category')->foreign('id_staff_category')->references('id')->on('tbl_staff_categories')->onDelete('cascade');
            $table->uuid('id_staff_subcategory')->foreign('id_staff_subcategory')->references('id')->on('tbl_staff_sub_categories')->onDelete('cascade');
            $table->string('primary_contact_no');
            $table->string('email_id');
            $table->date('joining_date');
            $table->String('duration_employment');
            $table->uuid('id_nationality')->foreign('id_nationality')->references('id')->on('tbl_nationality')->onDelete('cascade');
            $table->uuid('id_religion')->foreign('id_religion')->references('id')->on('tbl_religion')->onDelete('cascade');
            $table->uuid('id_caste_category')->foreign('id_caste_category')->references('id')->on('tbl_categories')->onDelete('cascade');
            $table->string('aadhaar_no')->nullable();
            $table->string('pancard_no')->nullable();
            $table->string('pf_uan_no');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->Integer('pincode');
            $table->string('country');
            $table->string('secondary_contact_no')->nullable();
            $table->text('staff_image')->nullable();
            $table->string('sms_for')->nullable();
            $table->string('attachment_aadhaar')->nullable();
            $table->string('attachment_pancard')->nullable();
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
        Schema::dropIfExists('tbl_staff');
    }
};
?>
