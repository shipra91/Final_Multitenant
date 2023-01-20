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
        Schema::table('tbl_fee_mapping', function (Blueprint $table) {
            $table->decimal('cgst')->after('priority')->nullable();
            $table->decimal('sgst')->after('cgst')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_fee_mapping', function (Blueprint $table) {
            $table->dropColumn('cgst');
            $table->dropColumn('sgst');
        });
    }
};
