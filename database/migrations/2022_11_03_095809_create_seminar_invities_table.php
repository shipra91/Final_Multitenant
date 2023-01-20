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
        Schema::create('tbl_seminar_invities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_seminar')->foreign('id_seminar')->references('id')->on('tbl_seminar')->onDelete('cascade');
            $table->enum('recipient_type', ['STAFF', 'STUDENT']);
            $table->uuid('id_staff_category')->foreign('id_staff_category')->references('id')->on('tbl_staff_categories')->onDelete('cascade');
            $table->uuid('id_staff_subcategory')->foreign('id_staff_subcategory')->references('id')->on('tbl_staff_sub_categories')->onDelete('cascade');
            $table->uuid('id_standard')->foreign('id_standard')->references('id')->on('tbl_institution_standard')->onDelete('cascade');
            $table->uuid('id_subject')->foreign('id_subject')->references('id')->on('tbl_institution_subject')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_seminar_invities');
    }
};
