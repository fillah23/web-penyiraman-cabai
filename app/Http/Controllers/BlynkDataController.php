<?php

namespace App\Http\Controllers;

use App\Models\BlynkData;
use Illuminate\Http\Request;

class BlynkDataController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'suhu' => 'nullable|string',
            'humidity' => 'nullable|string',
            'soil' => 'nullable|string',
            'status_penyiraman' => 'nullable|string',
            'pump_type' => 'nullable|string', // 'manual' or 'automated'
            'upper_limit' => 'nullable|integer',
            'lower_limit' => 'nullable|integer',
            'watering_time' => 'nullable|string', // Ensure the date format is valid
        ]);
    
        // Save the data to the database
        BlynkData::create($data);

        return response()->json(['message' => 'Data saved successfully!'], 201);
    }
}

