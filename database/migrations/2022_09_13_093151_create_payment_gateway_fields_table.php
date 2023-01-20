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
        Schema::create('tbl_payment_gateway_field', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_payment_gateway')->foreign('id_payment_gateway')->references('id')->on('tbl_payment_gateway')->onDelete('cascade');
            $table->string('field_label');
            $table->string('field_key');
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
        Schema::dropIfExists('tbl_payment_gateway_field');
    }
};
