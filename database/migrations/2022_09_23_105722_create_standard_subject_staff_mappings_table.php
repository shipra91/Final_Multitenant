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
        Schema::create('tbl_standard_subject_staff_mapping', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->String('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->String('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->uuid('id_standard')->foreign('id_standard')->references('id')->on('tbl_institution_standard')->onDelete('cascade');
            $table->uuid('id_subject')->foreign('id_subject')->references('id')->on('tbl_institution_subject')->onDelete('cascade');
            $table->uuid('id_staff')->foreign('id_staff')->references('id')->on('tbl_staff')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_standard_subject_staff_mapping');
    }
};
