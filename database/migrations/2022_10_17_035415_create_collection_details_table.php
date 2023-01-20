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
        Schema::create('tbl_fee_collection_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_fee_collection')->foreign('id_fee_collection')->references('id')->on('tbl_fee_collections')->onDelete('cascade');            
            $table->uuid('id_fee_mapping_heading')->foreign('id_fee_mapping_heading')->references('id')->on('tbl_fee_mapping')->onDelete('cascade');
            $table->Integer('installment_no');
            $table->Decimal('fee_amount');
            $table->Decimal('sgst_received')->nullable();
            $table->Decimal('cgst_received')->nullable();
            $table->Decimal('gst_received')->nullable();
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
        Schema::dropIfExists('tbl_fee_collection_details');
    }
};
