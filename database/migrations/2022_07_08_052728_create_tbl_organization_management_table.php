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
        Schema::create('tbl_organization_management', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_organization')->foreign('id_organization')->references('id')->on('tbl_organization')->onDelete('cascade');
            $table->String('name');
            $table->String('designation');
            $table->String('email');
            $table->String('mobile_number');
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
        Schema::dropIfExists('tbl_organization_management');
    }
};
