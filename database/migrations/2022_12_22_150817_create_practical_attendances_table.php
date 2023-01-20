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
        Schema::create('tbl_practical_attendance', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->uuid('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->uuid('id_standard')->foreign('id_standard')->references('id')->on('tbl_institution_standard')->onDelete('cascade');
            $table->uuid('id_subject')->foreign('id_subject')->references('id')->on('tbl_institution_subject')->onDelete('cascade')->nullable();
            $table->uuid('id_student')->foreign('id_student')->references('id')->on('tbl_student')->onDelete('cascade');
            $table->uuid('id_period')->foreign('id_period')->references('id')->on('tbl_periods')->onDelete('cascade');
            $table->uuid('id_batch')->foreign('id_batch')->references('id')->on('tbl_batch_student')->onDelete('cascade');
            $table->Date('held_on');
            $table->Enum('attendance_status', ['PRESENT', 'ABSENT']);
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
        Schema::dropIfExists('tbl_practical_attendance');
    }
};
