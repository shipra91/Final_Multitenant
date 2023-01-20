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
        Schema::table('tbl_institution_modules', function (Blueprint $table) {
            $table->uuid('id_parent')->default('0')->after('id_module');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_institution_modules', function (Blueprint $table) {
            $table->dropColumn('id_parent');
        });
    }
};
