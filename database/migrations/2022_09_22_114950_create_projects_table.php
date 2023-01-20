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
        Schema::create('tbl_project', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->uuid('id_academic')->foreign('id_academic')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->uuid('id_standard')->foreign('id_standard')->references('id')->on('tbl_institution_standard')->onDelete('cascade');
            $table->uuid('id_subject')->foreign('id_subject')->references('id')->on('tbl_standard_subject')->onDelete('cascade');
            $table->uuid('id_staff')->foreign('id_staff')->references('id')->on('tbl_staff')->onDelete('cascade');
            $table->String('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->String('chapter_name')->nullable();
            $table->String('start_time')->nullable();
            $table->String('end_time')->nullable();
            $table->String('submission_type')->nullable();
            $table->String('grading_required')->nullable();
            $table->String('grading_option')->nullable();
            $table->String('grade')->nullable();
            $table->String('marks')->nullable();
            $table->String('read_receipt')->nullable();
            $table->String('sms_alert')->nullable();
            $table->Text('description');
            $table->String('resubmission_time')->nullable();
            $table->date('resubmission_date')->nullable();
            $table->enum('resubmission_required', ['NO', 'YES']);
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
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
        Schema::dropIfExists('tbl_project');
    }
};
