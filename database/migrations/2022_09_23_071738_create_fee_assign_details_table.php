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
        Schema::create('tbl_fee_assign_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_fee_assign')->foreign('id_fee_assign')->references('id')->on('tbl_fee_assign')->onDelete('cascade');
            $table->uuid('id_fee_heading')->foreign('id_fee_heading')->references('id')->on('tbl_category_fee_heading_masters')->onDelete('cascade');
            $table->Enum('action_type', ['ASSIGNED', 'CONCESSION', 'ADDITION']);
            $table->Integer('installment_no')->nullable();
            $table->Decimal('amount')->nullable();
            $table->Date('due_date')->nullable();
            $table->String('remark', 500)->nullable();
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
        Schema::dropIfExists('tbl_fee_assign_details');
    }
};
