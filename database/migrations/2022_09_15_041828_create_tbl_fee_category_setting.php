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
        Schema::create('tbl_fee_category_setting', function (Blueprint $table) {
            $table->uuid('id')->primary();      
            $table->uuid('id_fee_master')->foreign('id_fee_master')->references('id')->on('tbl_fee_master')->onDelete('cascade');
            $table->Integer('no_of_installment')->nullable();
            $table->enum('installment_type', ['FIXED', 'VARIABLE'])->nullable();
            $table->enum('collection_type', ['PROPORTIONATE', 'PRIORITY'])->nullable();
            $table->decimal('amount')->nullable();
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
        Schema::dropIfExists('tbl_fee_category_setting');
    }
};
