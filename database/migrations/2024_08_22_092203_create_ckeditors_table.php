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
        Schema::create('ckeditors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->date('date');
            $table->string('image');
            $table->string('description'); 
            $table->string('status')->default('Y'); 
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ckeditors');
    }
};