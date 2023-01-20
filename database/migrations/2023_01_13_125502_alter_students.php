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
        Schema::table('tbl_student', function (Blueprint $table) {
            $table->String('guardian_middle_name')->nullable()->after('guardian_name');
            $table->String('guardian_last_name')->nullable()->after('guardian_middle_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_student', function (Blueprint $table) {
            $table->dropColumn('guardian_middle_name');
            $table->dropColumn('guardian_last_name');
        });
    }
};
