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
        Schema::create('tran_insurance_header', function (Blueprint $table) {
            $table->id();
            $table->string('policynumber')->nullable();
            $table->string('oldtransnumber')->nullable();
            $table->string('insurancetype')->nullable();
            $table->string('company')->nullable();
            $table->datetime('inceptiondate')->nullable();
            $table->datetime('expirydate')->nullable();
            $table->string('durations')->nullable();
            $table->string('broker')->nullable();
            $table->string('insurer')->nullable();
            $table->string('status')->nullable();
            $table->string('fullypaid')->nullable();
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
        Schema::dropIfExists('tran_insurance_header');
    }
};
