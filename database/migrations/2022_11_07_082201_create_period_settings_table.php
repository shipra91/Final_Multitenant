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
        Schema::create('tbl_period_setting', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->uuid('id_academic')->foreign('id_academic')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->uuid('id_standard')->foreign('id_standard')->references('id')->on('tbl_institution_standard')->onDelete('cascade');
            $table->string('days');
            $table->Integer('no_of_teaching_periods');
            $table->Integer('no_of_break_periods');
            $table->Integer('time_interval');
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
        Schema::dropIfExists('tbl_period_setting');
    }
};
