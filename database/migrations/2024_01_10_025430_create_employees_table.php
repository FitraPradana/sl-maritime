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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('absentno');
            $table->string('empname');
            $table->string('empemail');
            $table->string('sex')->nullable();
            $table->string('religioncode')->nullable();
            $table->string('bornplace')->nullable();
            $table->string('borndate')->nullable();
            $table->string('bloodtype')->nullable();
            $table->string('currentaddress')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
