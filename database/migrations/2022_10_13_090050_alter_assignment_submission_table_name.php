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
        Schema::table('tbl_assignment_submission', function (Blueprint $table) {
            $table->String('submitted_time')->nullable()->after('comments');
            $table->date('submitted_date')->nullable()->after('comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_assignment_submission', function (Blueprint $table) {
            $table->$table->dropColumn('submitted_date');
            $table->$table->dropColumn('submitted_time');
        });
    }
};
