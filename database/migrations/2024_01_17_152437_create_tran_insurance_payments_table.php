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
            $table->uuid('id')->primary();
            $table->string('tran_insurance_header_id', 30);
            $table->string('insurancetype')->nullable();
            $table->string('company')->nullable();
            $table->string('broker')->nullable();
            $table->string('insurer')->nullable();
            $table->string('installment_ke')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->datetime('duedate')->nullable();
            $table->datetime('paymentdate')->nullable();
            $table->string('durations')->nullable();
            // $table->string('status')->nullable();
            $table->string('status_payment')->nullable();
            $table->string('remark')->nullable();
            $table->boolean('deleteflag')->default(0);
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
