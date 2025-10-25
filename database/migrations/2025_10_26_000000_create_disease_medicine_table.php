<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('disease_medicine', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disease_id')->constrained()->onDelete('cascade');
            $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
            $table->string('dosage')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['disease_id', 'medicine_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('disease_medicine');
    }
};