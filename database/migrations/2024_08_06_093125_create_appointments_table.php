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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('animal_name');
            $table->enum('animal_type', ['cão', 'gato', 'tartaruga', 'pato', 'galinha']);
            $table->integer('age');
            $table->text('symptoms');
            $table->date('appointment_date');
            $table->enum('time_of_day', ['manhã', 'tarde']);
            $table->foreignId('doctor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
