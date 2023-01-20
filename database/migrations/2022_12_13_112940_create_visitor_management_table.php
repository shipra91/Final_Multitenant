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
        Schema::create('tbl_visitor_management', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->uuid('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->enum('type', ['VISITOR', 'SCHEDULED_VISITOR']);
            $table->string('visitor_name');
            $table->bigInteger('visitor_contact');
            $table->integer('visitor_age');
            $table->string('visitor_address');
            $table->enum('gender', ['MALE', 'FEMALE', 'OTHER']);
            $table->enum('person_to_meet', ['STUDENT', 'STAFF', 'PRINCIPAL', 'PRESIDENT', 'OTHERS']);
            $table->string('concerned_person')->nullable();
            $table->string('visit_purpose');
            $table->enum('visitor_type', ['PARENT', 'VENDOR', 'OTHERS']);
            $table->string('visitor_type_name')->nullable();
            $table->DateTime('visiting_datetime');
            $table->DateTime('end_datetime');
            $table->enum('visiting_status', ['PENDING', 'CANCELLED', 'SUCCESS']);
            $table->string('cancellation_reason')->nullable();
            $table->DateTime('cancelled_date')->nullable();
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
        Schema::dropIfExists('tbl_visitor_management');
    }
};
