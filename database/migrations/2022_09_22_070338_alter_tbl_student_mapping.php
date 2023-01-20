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
        Schema::table('tbl_student_mapping', function (Blueprint $table) {
            $table->Enum('detention', ['No', 'Yes'])->after('id_fee_type');
            $table->String('remark')->nullable()->after('detention');
            $table->Date('detention_date')->nullable()->after('remark');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_student_mapping', function (Blueprint $table) {
            $table->$table->dropColumn('detention');
            $table->$table->dropColumn('remark');
            $table->$table->dropColumn('detention_date');
        });
    }
};
