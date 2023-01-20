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
        Schema::table('tbl_create_fee_challans', function (Blueprint $table) {
            $table->dropColumn('transaction_no');
            $table->string('ifsc_code')->after('branch_name');
            $table->string('account_number')->after('branch_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_create_fee_challans', function (Blueprint $table) {
            $table->dropColumn('ifsc_code');
            $table->dropColumn('account_number');
        });
    }
};
