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
            $table->String('resubmission_time')->nullable()->after('description');
            $table->date('resubmission_date')->nullable()->after('description');
            $table->enum('resubmission_required', ['NO', 'YES'])->after('description');
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
            $table->$table->dropColumn('resubmission_required');
            $table->$table->dropColumn('resubmission_date');
            $table->$table->dropColumn('resubmission_time');
        });
    }
};
