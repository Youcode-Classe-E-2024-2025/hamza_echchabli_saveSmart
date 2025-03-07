<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->decimal('amount', 10, 2);
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('categorie_id')->constrained()->onDelete('cascade');
            $table->foreignId('type_id')->constrained('types')->onDelete('cascade'); // Foreign key for type
            $table->timestamps();
        });
        
    }

    
    
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
    

};
