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
        Schema::table('tbl_role', function (Blueprint $table) {
            $table->dropColumn('id_institution');
            $table->Enum('visibility', ['NO', 'YES'])->after('default');
        });
    }

    /**
     * Reverse the migrations.
     * 
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_role', function (Blueprint $table) {
            $table->uuid('id_institution');
        });
    }
};
