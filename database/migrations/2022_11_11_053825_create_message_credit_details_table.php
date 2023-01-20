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
        Schema::create('tbl_message_credit_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_message_credit')->foreign('id_message_credit')->references('id')->on('tbl_message_credit')->onDelete('cascade');
            $table->Integer('credit_numbers');
            $table->enum('credit_type', ['AS_PER_PO', 'PAID']);
            $table->date('amount_received_on')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('narration')->nullable();
            $table->string('transaction_id')->nullable();
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
        Schema::dropIfExists('tbl_message_credit_details');
    }
};
