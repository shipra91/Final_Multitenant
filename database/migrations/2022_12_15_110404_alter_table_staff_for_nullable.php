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
        Schema::table('tbl_staff', function (Blueprint $table) {
            $table->uuid('id_organization')->after('id');
            $table->uuid('id_academic_year')->nullable()->change();
            $table->uuid('id_institute')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_staff', function (Blueprint $table) {
            $table->dropColumn('id_organization');
            $table->dropColumn('id_academic_year');
            $table->dropColumn('id_institute');
        });
    }
};
