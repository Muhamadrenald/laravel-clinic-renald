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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            //patient id foreign key
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            //doctor id foreign key
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            //patient schedule id foreign key
            $table->foreignId('patient_schedule_id')->constrained('patient_schedules')->onDelete('cascade');
            //diagnosis
            $table->text('diagnosis');
            //medical_treratment nullable
            $table->text('medical_treatments')->nullable();
            //doctor_notes nullable
            $table->text('doctor_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
