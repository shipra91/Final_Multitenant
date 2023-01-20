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
        Schema::create('tbl_message_report', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->uuid('id_academic')->foreign('id_academic')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade');
            $table->uuid('id_message_center')->foreign('id_message_center')->references('id')->on('tbl_message_center')->onDelete('cascade');
            $table->string('message_type');
            $table->string('sender_id');
            $table->string('recipient_type');
            $table->uuid('id_recipient');
            $table->bigInteger('recipient_number');
            $table->string('sms_track_id');
            $table->string('sms_message_id');
            $table->string('sms_vendor');
            $table->string('sms_description');
            $table->dateTime('sms_sent_at');
            $table->dateTime('sms_delivered_at');
            $table->string('sent_status');
            $table->string('sms_charge');
            $table->Enum('completed',['NO', 'YES']);
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
        Schema::dropIfExists('tbl_message_report');
    }
};
