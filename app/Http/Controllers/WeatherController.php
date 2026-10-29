<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    public function index(Request $request)
    {
        // Kunin ang siyudad mula sa input, ang default ay 'Arakan'
        $city = $request->input('city', 'Arakan');
        $apiKey = env('OPENWEATHER_API_KEY');

        try {
            // May timeout na 5 segundo para sa error handling
            $response = Http::timeout(5)->get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $weather = [
                    'city' => $data['name'],
                    'temp' => $data['main']['temp'],
                    'description' => ucfirst($data['weather'][0]['description']),
                    'humidity' => $data['main']['humidity'],
                    'wind_speed' => $data['wind']['speed'],
                    'status' => 'success'
                ];
                
                return view('dashboard', compact('weather'));
            }
        } catch (\Exception $e) {
            Log::error('Weather API Error: ' . $e->getMessage());
        }

        // Fallback data kung sakaling magka-error o hindi mahanap ang siyudad
        $weather = [
            'city' => $city,
            'temp' => 'N/A',
            'description' => 'Hindi mahanap ang lokasyon o pansamantalang offline ang API',
            'humidity' => 'N/A',
            'wind_speed' => 'N/A',
            'status' => 'fallback'
        ];

        return view('dashboard', compact('weather'));
    }
}