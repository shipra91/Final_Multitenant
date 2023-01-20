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
        Schema::create('tbl_payment_gateway_values', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_payment_gateway_settings')->foreign('id_payment_gateway_settings')->references('id')->on('tbl_payment_gateway_settings')->onDelete('cascade');
            $table->uuid('id_gateway_fields')->foreign('id_gateway_fields')->references('id')->on(' tbl_payment_gateway_field')->onDelete('cascade');
            $table->string('field_value');
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
        Schema::dropIfExists('tbl_payment_gateway_values');
    }
};
