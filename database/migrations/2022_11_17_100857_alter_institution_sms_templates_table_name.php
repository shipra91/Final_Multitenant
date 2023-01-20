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
        Schema::table('tbl_institution_sms_templates', function (Blueprint $table) {
            $table->enum('status', ['1','0'])->nullable()->after('sms_template_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_institution_sms_templates', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
