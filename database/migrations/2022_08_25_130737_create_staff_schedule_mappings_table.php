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
        Schema::create('tbl_staff_schedule_mapping', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->uuid('id_staff')->foreign('id_staff')->references('id')->on('tbl_staff')->onDelete('cascade');
            $table->String('day');
            $table->String('start_time');
            $table->String('end_time');
            $table->softDeletes();
            $table->String('created_by')->nullable();
            $table->String('modified_by')->nullable();
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
        Schema::dropIfExists('tbl_staff_schedule_mapping');
    }
};
