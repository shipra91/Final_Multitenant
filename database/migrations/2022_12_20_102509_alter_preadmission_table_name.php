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
        Schema::table('tbl_preadmission', function (Blueprint $table) {
            $table->Enum('type',['OFFLINE','ONLINE'])->after('id_academic_year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_preadmission', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
