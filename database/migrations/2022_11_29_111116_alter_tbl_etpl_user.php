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
        Schema::table('tbl_etpl_users', function (Blueprint $table) {
            $table->String('fullname')->nullable()->after('emp_id');
            $table->String('contact')->nullable()->after('fullname');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_etpl_users', function (Blueprint $table) {
            $table->dropColumn('fullname');
            $table->dropColumn('contact');
        });
    }
};
