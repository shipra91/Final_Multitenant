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
        Schema::create('tbl_institution_standard', function (Blueprint $table) 
        {
            $table->uuid('id')->primary();
            $table->uuid('id_institution')->foreign('id_institution')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->uuid('id_standard')->foreign('id_standard')->references('id')->on('tbl_standard')->onDelete('cascade');
            $table->uuid('id_division')->foreign('id_division')->references('id')->on('tbl_division')->onDelete('cascade');
            $table->uuid('id_year')->foreign('id_year')->references('id')->on('tbl_standard_year')->onDelete('cascade'); 
            $table->uuid('id_sem')->foreign('id_sem')->references('id')->on('tbl_standard_sem')->onDelete('cascade');
            $table->uuid('id_stream')->foreign('id_stream')->references('id')->on('tbl_stream')->onDelete('cascade');
            $table->uuid('id_combination')->foreign('id_combination')->references('id')->on('	tbl_combination')->onDelete('cascade');
            $table->uuid('id_board')->foreign('id_board')->references('id')->on('tbl_board')->onDelete('cascade');
            $table->String('class_teacher_required');
            $table->String('id_class_teacher');
            $table->String('elective_required');
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
        Schema::dropIfExists('tbl_institution_standard');
    }
};
