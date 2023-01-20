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
        Schema::table('tbl_organization', function (Blueprint $table) {
            $table->renameColumn('poc_name','poc_name1');
            $table->renameColumn('poc_designation','poc_designation1');
            $table->renameColumn('poc_contact_number','poc_contact_number1');
            $table->renameColumn('poc_email','poc_email1');

            $table->String('post_office')->after('pincode')->nullable();

            $table->String('poc_name2')->after('poc_email')->nullable();
            $table->String('poc_designation2')->after('poc_name2')->nullable();
            $table->String('poc_contact_number2')->after('poc_designation2')->nullable();
            $table->String('poc_email2')->after('poc_contact_number2')->nullable();

            $table->String('poc_name3')->after('poc_email2')->nullable();
            $table->String('poc_designation3')->after('poc_name3')->nullable();
            $table->String('poc_contact_number3')->after('poc_designation3')->nullable();
            $table->String('poc_email3')->after('poc_contact_number3')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_organization', function (Blueprint $table) {
            $table->renameColumn('poc_name','poc_name1');
            $table->renameColumn('poc_designation','poc_designation1');
            $table->renameColumn('poc_contact_number','poc_contact_number1');
            $table->renameColumn('poc_email','poc_email1');

            $table->dropColumn('post_office');

            $table->dropColumn('poc_name2');
            $table->dropColumn('poc_designation2');
            $table->dropColumn('poc_contact_number2');
            $table->dropColumn('poc_email2');

            $table->dropColumn('poc_name3');
            $table->dropColumn('poc_designation3');
            $table->dropColumn('poc_contact_number3');
            $table->dropColumn('poc_email3');
        });
    }
};
