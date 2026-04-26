<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            
            // --- THIS IS THE MISSING LINE THAT FIXES YOUR ERROR ---
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Personal Info
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->date('birthdate');
            $table->string('place_of_birth');
            $table->string('sex');
            $table->string('citizenship')->default('Filipino');
            
            // Contact & Address
            $table->string('email')->unique();
            $table->string('contact_number');
            $table->text('address');
            
            // Education
            $table->string('school');
            $table->string('school_id');
            $table->string('school_sector');
            $table->string('school_address');
            $table->string('course');
            $table->string('year_level');
            $table->decimal('gpa', 5, 2);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};