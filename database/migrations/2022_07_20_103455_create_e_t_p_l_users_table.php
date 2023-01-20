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
        Schema::create('tbl_etpl_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('emp_id')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('is_activated', ['No','Yes']);
            $table->enum('type', ['service','developer']);
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
        Schema::dropIfExists('tbl_etpl_users');
    }
};
