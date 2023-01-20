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
        Schema::create('tbl_examroom_student_mapping', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->String('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->String('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->String('id_examination_room_setting')->foreign('id_examination_room_setting')->references('id')->on('tbl_examination_room_settings')->onDelete('cascade');
            $table->String('id_student')->foreign('id_student')->references('id')->on('tbl_student')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_examroom_student_mapping');
    }
};
