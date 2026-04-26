<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            // Connects the documents to the applicant
            $table->foreignId('applicant_id')->constrained()->onDelete('cascade');
            
            // Stores "cor" or "indigency" and where the file is saved
            $table->string('document_type');
            $table->string('file_path');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};