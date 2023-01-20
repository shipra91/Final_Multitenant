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
        Schema::table('tbl_fee_collection_details', function (Blueprint $table) {
            $table->uuid('id_fee_category')->foreign('id_fee_category')->references('id')->on(' tbl_fee_category')->onDelete('cascade')->after('id_fee_collection');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_fee_collection_details', function (Blueprint $table) {
            $table->dropColumn('id_fee_category');
        });
    }
};
