<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    use HasFactory;

    // $table->foreignId('patient_schedule_id')->constrained('patient_schedules')->onDelete('cascade');
    // //patient_id foreign key
    // $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
    // //payment_method enum('cash', 'qris')
    // $table->enum('payment_method', ['cash', 'qris']);
    // //total_price
    // $table->integer('total_price');
    // //transaction_time
    // $table->dateTime('transaction_time');

    protected $fillable = [
        'patient_schedule_id',
        'patient_id',
        'payment_method',
        'total_price',
        'transaction_time'
    ];

    public function patientSchedule()
    {
        return $this->belongsTo(PatientSchedule::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
