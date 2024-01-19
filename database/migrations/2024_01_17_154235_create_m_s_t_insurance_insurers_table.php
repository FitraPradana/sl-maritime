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
        Schema::create('mst_insurance_insurer', function (Blueprint $table) {
            $table->id();
            $table->string('insurercode')->nullable();
            $table->string('insurername')->nullable();
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
        Schema::dropIfExists('mst_insurance_insurer');
    }
};