<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tran_insurance_payment', function (Blueprint $table) {
            $table->id();
            $table->string('tran_insurance_header_id')->nullable();
            $table->string('insurancetype')->nullable();
            $table->string('company')->nullable();
            $table->string('broker')->nullable();
            $table->string('insurer')->nullable();
            $table->string('installment_ke')->nullable();
            $table->datetime('duedate')->nullable();
            $table->string('durations')->nullable();
            $table->string('status')->nullable();
            $table->string('remark')->nullable();
            $table->string('deleteflag')->nullable();
            $table->datetime('deleteat')->nullable();
            $table->datetime('createat')->nullable();
            $table->string('createby')->nullable();
            $table->datetime('updateat')->nullable();
            $table->string('updateby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tran_insurance_payment');
    }
};
