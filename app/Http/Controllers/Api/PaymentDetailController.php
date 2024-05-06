<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentDetails;

class PaymentDetailController extends Controller
{
    //index
    public function index(Request $request)
    {
        $paymentDetails = PaymentDetails::with(['patientSchedule', 'patient'])
            ->when($request->input('name'), function ($query, $name) {
                return $query->whereHas('patient', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        return response([
            'data' => $paymentDetails,
            'message' => 'Success',
            'status' => 'OK'
        ], 200);
    }

    //store
    public function store(Request $request)
    {
        //validate incoming request
        $request->validate([
            'patient_schedule_id' => 'required',
            'patient_id' => 'required',
            'payment_method' => 'required',
            'total_price' => 'required',
            'transaction_time' => 'required',
        ]);

        //store payment detail
        $paymentDetail = PaymentDetails::create([
            'patient_schedule_id' => $request->patient_schedule_id,
            'patient_id' => $request->patient_id,
            'payment_method' => $request->payment_method,
            'total_price' => $request->total_price,
            'transaction_time' => $request->transaction_time,
        ]);

        //update patient schedule status, payment method, and total price
        $patientSchedule = $paymentDetail->patientSchedule;
        $patientSchedule->status = 'completed';
        $patientSchedule->payment_method = $request->payment_method;
        $patientSchedule->total_price = $request->total_price;
        $patientSchedule->save();

        return response([
            'data' => $paymentDetail,
            'message' => 'Payment detail stored',
            'status' => 'OK'
        ], 201);
    }
}
