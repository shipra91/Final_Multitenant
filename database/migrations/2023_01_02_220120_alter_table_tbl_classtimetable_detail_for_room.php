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
        Schema::table('tbl_class_time_table_detail', function (Blueprint $table) {
            $table->uuid('id_room')->nullable()->after('id_staff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_class_time_table_detail', function (Blueprint $table) {
            $table->dropColumn('id_room');
        });
    }
};
