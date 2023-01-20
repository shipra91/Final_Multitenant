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
        Schema::table('tbl_fee_assign_details', function (Blueprint $table) {
            $table->Enum('concession_approved', ['PENDING','NO', 'YES'])->after('remark');
            $table->date('concession_approved_date')->after('remark')->nullable();
            $table->date('concession_rejected_date')->after('remark')->nullable();
            $table->String('concession_rejected_reason')->after('remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concession_approved');
        Schema::dropIfExists('concession_approved_date');
        Schema::dropIfExists('concession_rejected_date');
        Schema::dropIfExists('concession_rejected_reason');
    }
};
