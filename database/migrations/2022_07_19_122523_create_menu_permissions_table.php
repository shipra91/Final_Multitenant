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

        Schema::create('tbl_menu_permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_role')->foreign('id_role')->references('id')->on('tbl_role')->onDelete('cascade');
            $table->uuid('id_module')->foreign('id_module')->references('id')->on('tbl_module')->onDelete('cascade');
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_menu_permissions');
    }
};
