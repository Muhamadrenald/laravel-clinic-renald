<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceMedicinesController extends Controller
{
    //index
    public function index(Request $request)
    {
        //search service medicines by name
        $service_medicines = \App\Models\ServiceMedicines::when($request->input('name'), function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })
            ->orderBy('id', 'desc')
            ->get();

        return response([
            'data' => $service_medicines,
            'message' => 'Success',
            'status' => 'OK'
        ], 200);
    }
}
