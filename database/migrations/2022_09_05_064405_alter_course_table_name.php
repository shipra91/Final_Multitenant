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
        Schema::table('tbl_course', function (Blueprint $table) {
            $table->dropColumn('id_institution_type_mapping');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_course', function (Blueprint $table) {
            $table->dropColumn('id_institution_type_mapping');
           
        });
    }
};
