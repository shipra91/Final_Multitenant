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
        Schema::create('tbl_student_mapping', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_student')->foreign('id_student')->references('id')->on('tbl_student')->onDelete('cascade');
            $table->uuid('id_standard')->foreign('id_standard')->references('id')->on('tbl_institution_standard')->onDelete('cascade');
            $table->uuid('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->uuid('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->uuid('id_first_language')->foreign('id_first_language')->references('id')->on('tbl_subject')->onDelete('cascade');  
            $table->uuid('id_second_language')->foreign('id_second_language')->references('id')->on('tbl_subject')->onDelete('cascade');
            $table->uuid('id_third_language')->foreign('id_third_language')->references('id')->on('tbl_subject')->onDelete('cascade');
            $table->uuid('id_fee_type')->foreign('id_fee_type')->references('id')->on('tbl_fee_type')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_student_mapping');
    }
};
