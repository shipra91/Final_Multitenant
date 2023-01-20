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
        Schema::create('tbl_document_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_document')->foreign('id_document')->references('id')->on('tbl_document')->onDelete('cascade');
            $table->uuid('id_document_header')->foreign('id_document_header')->references('id')->on('tbl_document_header')->onDelete('cascade');
            $table->String('unique_id');
            $table->String('doc_count');
            $table->String('released_date')->nullable();
            $table->String('released_by')->nullable();
            $table->String('released_reason')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
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
        Schema::dropIfExists('tbl_document_detail');
    }
};
