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
            $table->String('chapter_name')->nullable()->after('end_date');
            $table->String('start_time')->nullable()->after('end_date');
            $table->String('end_time')->nullable()->after('end_date');
            $table->String('submission_type')->nullable()->after('end_date');
            $table->String('grading_required')->nullable()->after('end_date');
            $table->String('grading_option')->nullable()->after('end_date');
            $table->String('grade')->nullable()->after('end_date');
            $table->String('marks')->nullable()->after('end_date');
            $table->String('read_receipt')->nullable()->after('end_date');
            $table->String('sms_alert')->nullable()->after('end_date');
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
            $table->$table->dropColumn('chapter_name');
            $table->$table->dropColumn('start_time');
            $table->$table->dropColumn('end_time');
            $table->$table->dropColumn('submission_type');
            $table->$table->dropColumn('grading_required');
            $table->$table->dropColumn('grading_option');
            $table->$table->dropColumn('grade');
            $table->$table->dropColumn('marks');
            $table->$table->dropColumn('read_receipt');
            $table->$table->dropColumn('sms_alert');
        });
    }
};
