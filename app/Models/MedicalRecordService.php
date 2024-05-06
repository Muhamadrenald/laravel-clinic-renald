<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecordService extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_records_id',
        'service_medicines_id',
        'quantity'
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecords::class);
    }

    public function serviceMedicine()
    {
        return $this->belongsTo(ServiceMedicines::class);
    }
}
