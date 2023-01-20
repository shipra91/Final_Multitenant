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
        Schema::create('tbl_fee_installment', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_fee_assign');
            $table->Integer('installment_no');
            $table->decimal('amount')->nullable();
            $table->decimal('percentage')->nullable();
            $table->date('due_date')->nullable();
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
        Schema::dropIfExists('tbl_fee_installment');
    }
};
