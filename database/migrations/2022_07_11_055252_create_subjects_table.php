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
        Schema::create('tbl_subject', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_type')->foreign('id_type')->references('id')->on('tbl_subject_type')->onDelete('cascade');
            $table->String('name');
            $table->String('code')->nullable();  
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
        Schema::dropIfExists('tbl_subject');
    }
};
