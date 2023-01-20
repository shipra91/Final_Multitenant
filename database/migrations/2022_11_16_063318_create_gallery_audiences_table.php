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
        Schema::create('tbl_gallery_audience', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_gallery')->foreign('id_gallery')->references('id')->on('tbl_gallery')->onDelete('cascade');
            $table->enum('audience_type', ['STAFF', 'STUDENT']);
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
        Schema::dropIfExists('tbl_gallery_audience');
    }
};
