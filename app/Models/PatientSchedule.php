<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'schedule_time',
        'complaint',
        'status',
        'no_antrian',
        'payment_method',
        'total_price'
    ];

    // nama function/method disesuaikan dengan nama model yang akan dihubungkan
    public function patient()
    {
        // 1 jadwal pasien dimiliki 1 pasien
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
