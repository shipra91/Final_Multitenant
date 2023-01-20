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
        Schema::create('tbl_combination_subjects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_combination')->foreign('id_combination')->references('id')->on('tbl_combination')->onDelete('cascade');
            $table->uuid('id_subject')->foreign('id_subject')->references('id')->on('tbl_subject')->onDelete('cascade');
            $table->string('created_by');
            $table->string('modified_by');
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
        Schema::dropIfExists('tbl_combination_subjects');
    }
};
