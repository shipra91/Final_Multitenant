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
        Schema::table('tbl_fee_collections', function (Blueprint $table) {
            $table->Decimal('total_fine_amount')->nullable()->after('gst');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_fee_collections', function (Blueprint $table) {
            $table->dropColumn('total_fine_amount');
        });
    }
};
