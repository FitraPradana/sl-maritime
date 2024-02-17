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
        Schema::create('phising_targets', function (Blueprint $table) {
            $table->id();
            $table->string('phising_type')->nullable();
            $table->string('no_absent_target')->nullable();
            $table->string('name_target')->nullable();
            $table->string('email_target')->nullable();
            $table->string('is_sendMail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phising_targets');
    }
};
