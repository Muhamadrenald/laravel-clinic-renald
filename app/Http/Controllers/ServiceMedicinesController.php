<?php

namespace App\Http\Controllers;

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
            ->paginate(10);

        return view('pages.service_medicines.index', compact('service_medicines'));
    }

    //create
    public function create()
    {
        return view('pages.service_medicines.create');
    }

    //store
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        $service_medicines = \App\Models\ServiceMedicines::create($request->all());

        return redirect()->route('service-medicines.index')->with('success', 'Service Medicines created successfully');
    }

    //edit
    public function edit($id)
    {
        $service_medicines = \App\Models\ServiceMedicines::find($id);

        return view('pages.service_medicines.edit', compact('service_medicines'));
    }

    //update
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        $service_medicines = \App\Models\ServiceMedicines::find($id);
        $service_medicines->update($request->all());

        return redirect()->route('service-medicines.index')->with('success', 'Service Medicines updated successfully');
    }

    //destroy
    public function destroy($id)
    {
        $service_medicines = \App\Models\ServiceMedicines::find($id);
        $service_medicines->delete();

        return redirect()->route('service-medicines.index')->with('success', 'Service Medicines deleted successfully');
    }
}
