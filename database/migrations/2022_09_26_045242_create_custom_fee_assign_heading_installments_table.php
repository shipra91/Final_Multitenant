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
        Schema::create('tbl_custom_fee_assign_heading_installment', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_custom_fee_assign_heading')->foreign('id_custom_fee_assign_heading')->references('id')->on('tbl_custom_fee_assign_heading')->onDelete('cascade');
            $table->Integer('installment_no');
            $table->Decimal('amount');
            $table->Decimal('percentage');
            $table->Date('due_date');
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
        Schema::dropIfExists('tbl_custom_fee_assign_heading_installment');
    }
};
