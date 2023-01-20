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
        Schema::create('tbl_module_dynamic_tokens_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('module')->foreign('module')->references('module_label')->on('tbl_module')->onDelete('cascade');
            $table->text('is_mapped_with');
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
        Schema::dropIfExists('tbl_module_dynamic_tokens_mappings');
    }
};
