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
        Schema::create('tbl_fee_master', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->uuid('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->uuid('id_fee_category')->foreign('id_fee_category')->references('id')->on('tbl_fee_category')->onDelete('cascade');
            $table->uuid('id_institution_standard')->foreign('id_institution_standard')->references('id')->on('tbl_institution_standard')->onDelete('cascade');
            $table->uuid('id_fee_type')->foreign('id_fee_type')->references('id')->on('tbl_fee_type')->onDelete('cascade');
            $table->enum('installment_type', ['CATEGORY_WISE', 'HEADING_WISE']);
            $table->String('created_by')->nullable();
            $table->String('modified_by')->nullable();
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
        Schema::dropIfExists('tbl_fee_master');
    }
};
