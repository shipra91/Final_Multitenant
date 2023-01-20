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
        Schema::create('tbl_category_fee_heading_masters', function (Blueprint $table) {
            $table->uuid('id')->primary();      
            $table->uuid('id_category_setting')->foreign('id_category_setting')->references('id')->on('tbl_fee_category_setting')->onDelete('cascade');
            $table->String('id_fee_heading')->nullable();
            $table->Decimal('heading_amount')->nullable();
            $table->Integer('collection_priority')->nullable();
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
        Schema::dropIfExists('tbl_category_fee_heading_masters');
    }
};
