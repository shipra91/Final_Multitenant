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
        Schema::create('tbl_staff_family_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_staff')->foreign('id_staff')->references('id')->on('tbl_staff')->onDelete('cascade');
            $table->string('name');
            $table->string('phone');
            $table->string('relation');
            $table->softDeletes();
            $table->String('created_by')->nullable();
            $table->String('modified_by')->nullable();
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
        Schema::dropIfExists('tbl_staff_family_detail');
    }
};
