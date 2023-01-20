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
        Schema::table('tbl_assignment', function (Blueprint $table) {
            $table->dropColumn(['resubmission_required', 'resubmission_date', 'resubmission_time']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_assignment', function (Blueprint $table) {
            $table->dropColumn(['resubmission_required', 'resubmission_date', 'resubmission_time']);
        });
    }
};
