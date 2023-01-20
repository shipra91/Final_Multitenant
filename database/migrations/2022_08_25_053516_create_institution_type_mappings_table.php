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
        Schema::create('tbl_institution_type_mapping', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_board_university')->foreign('id_board_university')->references('id')->on('tbl_board')->onDelete('cascade');
            $table->uuid('id_institution_type')->foreign('id_institution_type')->references('id')->on('tbl_institution_type')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_institution_type_mapping');
    }
};
