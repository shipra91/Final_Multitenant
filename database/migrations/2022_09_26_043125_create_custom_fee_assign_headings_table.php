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
        Schema::create('tbl_custom_fee_assign_heading', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_custom_fee_assign')->foreign('id_custom_fee_assign')->references('id')->on('tbl_custom_fee_assignment')->onDelete('cascade');
            $table->uuid('id_heading')->foreign('id_heading')->references('id')->on('tbl_fee_heading')->onDelete('cascade');
            $table->Decimal('amount');
            $table->Integer('no_of_installment')->nullable();
            $table->Enum('installment_type', ['FIXED', 'VARIABLE'])->nullable();
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
        Schema::dropIfExists('tbl_custom_fee_assign_heading');
    }
};
