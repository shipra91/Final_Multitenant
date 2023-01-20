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
        Schema::create('tbl_homework_submission_permission', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_homework')->foreign('id_homework')->references('id')->on('tbl_homework')->onDelete('cascade');
            $table->uuid('id_student')->foreign('id_student')->references('id')->on('tbl_student')->onDelete('cascade');
            $table->enum('resubmission_allowed', ['NO', 'YES']);
            $table->date('resubmission_date')->nullable();
            $table->string('resubmission_time')->nullable();
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
        Schema::dropIfExists('tbl_homework_submission_permission');
    }
};
