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
            $table->String('id_first_language')->nullable()->change();
            $table->String('id_second_language')->nullable()->change();
            $table->String('id_third_language')->nullable()->change();
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
            $table->String('id_first_language')->nullable()->change();
            $table->String('id_second_language')->nullable()->change();
            $table->String('id_third_language')->nullable()->change();
        });
    }
};
