<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlynkData extends Model
{
    use HasFactory;

    protected $table = 'blynk_data'; // Specify the table name

    // Define the fillable attributes
    protected $fillable = [
        'suhu',
        'humidity',
        'soil',
        'status_penyiraman',
        'pump_type',      // New field for pump type
        'upper_limit',    // New field for upper limit
        'lower_limit',    // New field for lower limit
        'watering_time',  // New field for watering time
    ];
}
