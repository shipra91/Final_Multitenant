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
        Schema::create('tbl_room_master', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->String('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->String('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->String('building_name');
            $table->String('block_name')->nullable();
            $table->String('floor_number')->nullable();
            $table->String('room_number')->nullable();
            $table->String('display_name')->nullable();
            $table->String('capacity')->nullable();
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
        Schema::dropIfExists('tbl_room_master');
    }
};
