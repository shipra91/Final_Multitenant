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
        Schema::create('tbl_student_leave_attachment', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_leave_application')->foreign('id_leave_application')->references('id')->on('tbl_student_leave_application')->onDelete('cascade');
            $table->string('file_url');
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
        Schema::dropIfExists('tbl_student_leave_attachment');
    }
};
