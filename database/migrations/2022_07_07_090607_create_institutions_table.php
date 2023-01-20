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
        Schema::create('tbl_institution', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_organization')->foreign('id_organization')->references('id')->on('tbl_organization')->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->Integer('pincode');
            $table->string('country');
            $table->string('state');
            $table->string('district');
            $table->string('taluk');
            $table->string('city');
            $table->string('office_email');
            $table->string('mobile_number');
            $table->string('landline_number');
            $table->string('website_url');
            $table->uuid('id_institution_type')->foreign('id_institution_type')->references('id')->on('tbl_institution_type')->onDelete('cascade');
            $table->string('university');
            $table->string('institution_code');
            $table->string('institution_logo');
            $table->string('fav_icon')->nullable();
            $table->string('sender_id')->nullable();
            $table->string('entity_id')->nullable();
            $table->string('area_partner_name');
            $table->string('area_partner_email');
            $table->string('area_partner_phone');
            $table->string('zonal_partner_name');
            $table->string('zonal_partner_email');
            $table->string('zonal_partner_phone');
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
        Schema::dropIfExists('tbl_institution');
    }
};
