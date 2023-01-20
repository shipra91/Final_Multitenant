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
        Schema::create('tbl_student_leave_application', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->uuid('id_academic')->foreign('id_academic')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->uuid('id_student')->foreign('id_student')->references('id')->on('tbl_student')->onDelete('cascade');
            $table->String('title');
            $table->date('from_date');
            $table->date('to_date');
            $table->Text('leave_detail');
            $table->enum('leave_status', ['PENDING', 'APPROVE', 'REJECT']);
            $table->String('rejected_date')->nullable();
            $table->String('rejected_by')->nullable();
            $table->String('rejected_reason')->nullable();
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
        Schema::dropIfExists('tbl_student_leave_application');
    }
};
