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
        Schema::create('tbl_project_submission_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_project_submission')->foreign('id_project_submission')->references('id')->on('tbl_project_submission')->onDelete('cascade');
            $table->string('submitted_file');
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
        Schema::dropIfExists('tbl_project_submission_details');
    }
};
