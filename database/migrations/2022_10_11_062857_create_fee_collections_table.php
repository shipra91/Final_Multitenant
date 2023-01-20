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
        Schema::create('tbl_fee_collections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->uuid('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->uuid('id_student')->foreign('id_student')->references('id')->on('tbl_student')->onDelete('cascade');
            $table->uuid('id_receipt_setting')->foreign('id_receipt_setting')->references('id')->on('tbl_fee_receipt_settings')->onDelete('cascade');
            $table->String('collected_by');
            $table->Date('paid_date');
            $table->String('payment_mode');
            $table->String('receipt_prefix');
            $table->Integer('receipt_no');
            $table->String('transaction_no')->nullable();
            $table->String('bank_name')->nullable();
            $table->String('branch_name')->nullable();
            $table->Date('transaction_date')->nullable();
            $table->Decimal('amount_received');
            $table->Decimal('sgst')->nullable();
            $table->Decimal('cgst')->nullable();
            $table->Decimal('gst')->nullable();
            $table->String('orderId_online')->nullable();
            $table->enum('cancelled', ['NO', 'YES']);
            $table->String('cancelled_by')->nullable();
            $table->Date('cancelled_date')->nullable();
            $table->Text('cancellation_remarks')->nullable();
            $table->Text('remarks')->nullable();
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
        Schema::dropIfExists('tbl_fee_collections');
    }
};
