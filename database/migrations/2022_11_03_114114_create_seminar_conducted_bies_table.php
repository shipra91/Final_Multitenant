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
        Schema::create('tbl_seminar_conducted_by', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_seminar')->foreign('id_seminar')->references('id')->on('tbl_seminar')->onDelete('cascade');
            $table->uuid('conducted_by');
            $table->enum('type', ['STAFF', 'STUDENT']);
            $table->String('obtained_marks')->nullable();
            $table->String('remarks')->nullable();
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
        Schema::dropIfExists('tbl_seminar_conducted_by');
    }
};
