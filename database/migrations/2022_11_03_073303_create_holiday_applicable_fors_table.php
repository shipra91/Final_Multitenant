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
        Schema::create('tbl_holiday_applicable_for', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_holiday')->foreign('id_holiday')->references('id')->on('tbl_holiday')->onDelete('cascade');
            $table->enum('applicable_for', ['STAFF', 'STUDENT']);
            $table->uuid('id_staff_category')->nullable();
            $table->uuid('id_staff_subcategory')->nullable();
            $table->uuid('id_standard')->nullable();
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
        Schema::dropIfExists('tbl_holiday_applicable_for');
    }
};
