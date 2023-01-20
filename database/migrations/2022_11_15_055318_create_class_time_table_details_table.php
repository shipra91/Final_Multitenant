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
        Schema::create('tbl_class_time_table_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_class_time_table')->foreign('id_class_time_table')->references('id')->on('tbl_class_time_table')->onDelete('cascade');
            $table->uuid('id_subject');
            $table->uuid('id_staff');
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
        Schema::dropIfExists('tbl_class_time_table_detail');
    }
};
