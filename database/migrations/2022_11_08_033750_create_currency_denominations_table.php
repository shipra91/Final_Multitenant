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
        Schema::create('tbl_currency_denominations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->uuid('id_academic')->foreign('id_academic')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->uuid('id_student')->foreign('id_student')->references('id')->on('tbl_student')->onDelete('cascade');
            $table->uuid('id_fee_collection')->foreign('id_fee_collection')->references('id')->on('tbl_fee_collections')->onDelete('cascade');
            $table->Integer('denomination_type');
            $table->Integer('denomination_count');
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
        Schema::dropIfExists('tbl_currency_denominations');
    }
};
