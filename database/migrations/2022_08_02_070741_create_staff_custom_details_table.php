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
        Schema::create('tbl_staff_custom_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_staff')->foreign('id_staff')->references('id')->on('tbl_staff')->onDelete('cascade');
            $table->uuid('id_custom_field')->foreign('id_custom_field')->references('id')->on('tbl_custom_fields')->onDelete('cascade');
            $table->text('field_value');
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
        Schema::dropIfExists('tbl_staff_custom_details');
    }
};
