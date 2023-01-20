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
            $table->String('middle_name')->nullable()->after('name');
            $table->String('last_name')->nullable()->after('middle_name');
            $table->String('father_middle_name')->nullable()->after('father_name');
            $table->String('father_last_name')->nullable()->after('father_middle_name');
            $table->String('mother_middle_name')->nullable()->after('mother_name');
            $table->String('mother_last_name')->nullable()->after('mother_middle_name');
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
            $table->dropColumn('middle_name');
            $table->dropColumn('last_name');
            $table->dropColumn('father_middle_name');
            $table->dropColumn('father_last_name');
            $table->dropColumn('mother_middle_name');
            $table->dropColumn('mother_last_name');
        });
    }
};
