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
            $table->uuid('id_organization')->foreign('id_organization')->references('id')->on('tbl_organization')->onDelete('cascade')->after('id_standard');
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
            $table->dropColumn('id_organization');
        });
    }
};
