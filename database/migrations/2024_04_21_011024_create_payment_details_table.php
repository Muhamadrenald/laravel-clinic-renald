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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            //patient_schedule_id foreign key
            $table->foreignId('patient_schedule_id')->constrained('patient_schedules')->onDelete('cascade');
            //patient_id foreign key
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            //payment_method enum('cash', 'qris')
            $table->enum('payment_method', ['cash', 'qris']);
            //total_price
            $table->integer('total_price');
            //transaction_time
            $table->dateTime('transaction_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
