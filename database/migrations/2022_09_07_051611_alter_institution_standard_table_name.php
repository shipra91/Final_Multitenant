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
        Schema::table('tbl_institution_standard', function (Blueprint $table) {
            $table->renameColumn('id_institution','id_institute');
            $table->uuid('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade')->after('id_institution');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_institution_standard', function (Blueprint $table) {
            $table->renameColumn('id_institution','id_institute');
            $table->String('id_academic_year')->after('id_institution')->nullable();
            
        });
    }
};
