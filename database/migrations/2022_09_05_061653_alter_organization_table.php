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
        Schema::table('tbl_organization', function (Blueprint $table) {
            //
            $table->Enum('type', ['SINGLE', 'MULTIPLE'])->after('id');
            $table->String('landline_number')->nullable()->change();
            $table->String('gst_number')->nullable()->change();
            $table->String('pan_number')->nullable()->change();
            $table->String('website_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_organization', function (Blueprint $table) {
            $table->dropColumn('landline_number');
            $table->dropColumn('gst_number');
            $table->dropColumn('pan_number');
            $table->dropColumn('website_url');
        });
    }
};
