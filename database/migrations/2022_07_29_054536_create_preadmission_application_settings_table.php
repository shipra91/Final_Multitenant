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
        Schema::create('tbl_preadmission_application_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_academic')->foreign('id_academic')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->uuid('id_institution')->foreign('id_institution')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->string('name')->unique();
            $table->string('prefix')->unique();
            $table->integer('starting_number');
            $table->text('standards')->nullable();
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
        Schema::dropIfExists('tbl_preadmission_application_settings');
    }
};
