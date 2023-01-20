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
        Schema::create('tbl_assignment_submission', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_assignment')->foreign('id_assignment')->references('id')->on('tbl_assignment')->onDelete('cascade');
            $table->uuid('id_student')->foreign('id_student')->references('id')->on('tbl_student')->onDelete('cascade');
            $table->string('obtained_marks')->nullable();
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('tbl_assignment_submission');
    }
};
