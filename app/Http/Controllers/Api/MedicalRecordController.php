<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecords;
use App\Models\ServiceMedicines;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    //index
    public function index(Request $request)
    {
        $medicalRecords = MedicalRecords::with('doctor', 'patient', 'medicalRecordServices')
            ->when($request->input('name'), function ($query, $name) {
                return $query->whereHas('patient', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        return response([
            'data' => $medicalRecords,
            'message' => 'Success',
            'status' => 'OK'
        ], 200);
    }

    //store
    public function store(Request $request)
    {
        //validate incoming request
        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'patient_schedule_id' => 'required',
            'diagnosis' => 'required',
            'services' => 'required|array',
            'services.*.id' => 'required',
            'services.*.quantity' => 'required',
        ]);

        //store medical record
        $medicalRecord = MedicalRecords::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'patient_schedule_id' => $request->patient_schedule_id,
            'diagnosis' => $request->diagnosis,
            'medical_treatments' => $request->medical_treatments,
            'doctor_notes' => $request->doctor_notes,
            'status' => 'processed',
        ]);

        //store medical record services
        $totalPrice = 0;
        foreach ($request->services as $service) {
            $medicalRecord->medicalRecordServices()->create([
                'medical_records_id' => $medicalRecord->id,
                'service_medicines_id' => $service['id'],
                'quantity' => $service['quantity'],
            ]);
            $totalPrice += ServiceMedicines::find($service['id'])->price;
        }

        //update patient schedule status
        $patientSchedule = $medicalRecord->patientSchedule;
        $patientSchedule->status = 'processed';
        //update total price
        $patientSchedule->total_price = $totalPrice;
        $patientSchedule->save();

        return response([
            'data' => $medicalRecord,
            'message' => 'Medical record stored',
            'status' => 'OK'
        ], 201);
    }

    public function getServicesByScheduleId($scheduleId)
    {
        $medicalRecords = MedicalRecords::where('patient_schedule_id', $scheduleId)->get();

        $services = [];

        foreach ($medicalRecords as $medicalRecord) {
            foreach ($medicalRecord->medicalRecordServices as $service) {
                $serviceMedicine = ServiceMedicines::find($service->service_medicines_id);
                $services[] = [
                    'id' => $service->service_medicines_id,
                    'quantity' => $service->quantity,
                    'name' => $serviceMedicine->name,
                    'price' => $serviceMedicine->price,
                    'total' => $service->quantity * $serviceMedicine->price
                ];
            }
        }

        return response([
            'data' => $services,
            'message' => 'Success',
            'status' => 'OK'
        ], 200);
    }
}
