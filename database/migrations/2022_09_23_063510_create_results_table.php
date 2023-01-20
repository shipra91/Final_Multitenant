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
        Schema::create('tbl_result', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->String('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->String('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->uuid('id_exam')->foreign('id_exam')->references('id')->on('tbl_exam_master')->onDelete('cascade');
            $table->uuid('id_subject')->foreign('id_subject')->references('id')->on('tbl_institution_subject')->onDelete('cascade');
            $table->uuid('id_standard')->foreign('id_standard')->references('id')->on('tbl_institution_standard')->onDelete('cascade');
            $table->String('id_student')->foreign('id_student')->references('id')->on('tbl_student')->onDelete('cascade');
            $table->decimal('external_score')->nullable();
            $table->decimal('internal_max')->nullable();
            $table->decimal('internal_score')->nullable();
            $table->decimal('total_max')->nullable();
            $table->decimal('total_score')->nullable();
            $table->String('grade')->nullable();
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
        Schema::dropIfExists('tbl_result');
    }
};
