<?php

namespace App\Http\Controllers;

use App\Models\BlynkData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class BlynkDataController extends Controller
{


public function index()
{
    // Mengambil dan mengurutkan data berdasarkan created_at
    $data = DB::table('blynk_data')
        ->select('id', 'suhu', 'humidity', 'soil', 'created_at')
        ->orderBy('created_at', 'asc')
        ->get();

    // Inisialisasi variabel untuk menyimpan created_at sebelumnya
    $previousCreatedAt = null;
    $totalTimeDifference = 0;
    $count = 0;

    // Iterasi melalui data untuk menghitung selisih waktu
    $data = $data->map(function ($item) use (&$previousCreatedAt, &$totalTimeDifference, &$count) {
        if ($previousCreatedAt) {
            // Hitung selisih dalam jam
            $item->time_difference = Carbon::parse($previousCreatedAt)
                ->diffInHours(Carbon::parse($item->created_at));
            $totalTimeDifference += $item->time_difference;
            $count++;
        } else {
            $item->time_difference = 0; // Untuk item pertama, selisihnya 0
        }
        $previousCreatedAt = $item->created_at;
        return $item;
    });

    // Hitung rata-rata selisih waktu (dalam jam)
    $averageTimeDifference = $count > 0 ? $totalTimeDifference / $count : 0;

    // Ambil created_at dari item terakhir
    $lastCreatedAt = Carbon::parse($data->last()->created_at);

    // Prediksi waktu penyiraman berikutnya
    $predictedNextWatering = $lastCreatedAt->addHours($averageTimeDifference);

    return view('prediksi', [
        'data' => $data,
        'predictedNextWatering' => $predictedNextWatering
    ]);
}



    public function store(Request $request)
    {
        // Jika status_penyiraman adalah "Pompa Hidup", hanya simpan created_at
        if ($request->input('status_penyiraman') === "Pompa Hidup") {
            $blynkData = BlynkData::create([
                'suhu' => null,
                'humidity' => null,
                'soil' => null,
                'status_penyiraman' => null,
                'pump_type' => null,
                'upper_limit' => null,
                'lower_limit' => null,
                'watering_time' => null,
                'created_at' => now(), // Hanya menyimpan waktu
            ]);

            return response()->json(['message' => 'Pompa Hidup - Data Waktu Penyiraman Tersimpan'], 201);
        }

        // Jika bukan "Pompa Hidup", simpan semua data sesuai request
        $validatedData = $request->validate([
            'suhu' => 'nullable|string',
            'humidity' => 'nullable|string',
            'soil' => 'nullable|string',
            'status_penyiraman' => 'nullable|string',
            'pump_type' => 'nullable|string|in:manual,automated',
            'upper_limit' => 'nullable|string',
            'lower_limit' => 'nullable|string',
            'watering_time' => 'nullable|string',
        ]);

        $blynkData = BlynkData::create($validatedData);

        return response()->json($blynkData, 201);
    }

}
