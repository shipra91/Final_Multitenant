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
            $table->Decimal('fine_amount')->nullable()->after('gst_received');
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
            $table->dropColumn('fine_amount');
        });
    }
};
