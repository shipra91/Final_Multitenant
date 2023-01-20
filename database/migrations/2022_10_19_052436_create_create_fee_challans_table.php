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
        Schema::create('tbl_create_fee_challans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->uuid('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->uuid('id_student')->foreign('id_student')->references('id')->on('tbl_student')->onDelete('cascade');
            $table->String('challan_created_by'); 
            $table->Integer('challan_no');
            $table->String('payment_mode');
            $table->String('transaction_no')->unique();
            $table->String('bank_name');
            $table->String('branch_name');
            $table->Date('transaction_date');
            $table->Decimal('amount_received');
            $table->Decimal('sgst')->nullable();
            $table->Decimal('cgst')->nullable();
            $table->Decimal('gst')->nullable();
            $table->enum('approved', ['PENDING','NO', 'YES',]);
            $table->String('approved_by')->nullable();
            $table->Date('approved_date')->nullable();
            $table->String('bank_transaction_id')->nullable();
            $table->String('rejection_reason');
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
        Schema::dropIfExists('tbl_create_fee_challans');
    }
};
