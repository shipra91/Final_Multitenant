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
        Schema::create('tbl_role', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_institution')->foreign('id_institution')->references('id')->on('tbl_institution')->onDelete('cascade');
            $table->string('display_name');
            $table->string('label');
            $table->enum('default', ['No','Yes']);
            $table->string('created_by');
            $table->string('modified_by');
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
        Schema::dropIfExists('tbl_role');
    }
};
