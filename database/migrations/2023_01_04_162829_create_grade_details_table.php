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
        Schema::create('tbl_grade_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_grade')->foreign('id_grade')->references('id')->on('tbl_grade')->onDelete('cascade');
            $table->String('grade_name');
            $table->decimal('range_from');
            $table->decimal('range_to');
            $table->String('remark');
            $table->decimal('avg_point');
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
        Schema::dropIfExists('tbl_grade_detail');
    }
};
