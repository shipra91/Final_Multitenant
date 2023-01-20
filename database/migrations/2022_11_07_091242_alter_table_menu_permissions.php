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
        Schema::table('tbl_menu_permissions', function (Blueprint $table) {
            $table->uuid('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade')->after('id');
            $table->uuid('id_academic')->foreign('id_academic')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade')->after('id_institute');
            $table->Enum('view', ['NO', 'YES'])->after('id_module');
            $table->Enum('view_own', ['NO', 'YES'])->after('view');
            $table->Enum('create', ['NO', 'YES'])->after('view_own');
            $table->Enum('edit', ['NO', 'YES'])->after('create');
            $table->Enum('delete', ['NO', 'YES'])->after('edit');
            $table->Enum('export', ['NO', 'YES'])->after('delete');
            $table->Enum('import', ['NO', 'YES'])->after('export');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_menu_permissions', function (Blueprint $table) {
            $table->dropColumn('id_institute');
            $table->dropColumn('id_academic');
            $table->dropColumn('view');
            $table->dropColumn('view_own');
            $table->dropColumn('create');
            $table->dropColumn('edit');
            $table->dropColumn('delete');
            $table->dropColumn('export');
            $table->dropColumn('import');
        });
    }
};
