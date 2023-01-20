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
        Schema::create('tbl_organization', function (Blueprint $table) {
            $table->uuid('id')->primary();
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
            $table->string('poc_name');
            $table->string('poc_designation');
            $table->string('poc_contact_number');
            $table->string('poc_email');
            $table->string('website_url');
            $table->string('gst_number');
            $table->string('gst_attachment')->nullable();
            $table->string('pan_number');
            $table->string('pan_attachment')->nullable();
            $table->string('registration_certificate')->nullable();
            $table->string('logo');
            $table->date('po_signed_date');
            $table->date('po_effective_date');
            $table->string('po_attachment')->nullable();
            $table->string('contract_period');
            $table->date('po_expiry_date')->nullable()->default(null);
            $table->date('yearly_renewal_period')->nullable()->default(null);
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
        Schema::dropIfExists('tbl_organization');
    }
};
