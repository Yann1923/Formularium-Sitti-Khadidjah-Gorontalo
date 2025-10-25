<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BMIController extends Controller
{
    public function index()
    {
        return view('bmi.index');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'weight' => 'required|numeric|min:1|max:500',
            'height' => 'required|numeric|min:50|max:300',
        ]);

        $weight = $request->weight; // dalam kg
        $height = $request->height / 100; // konversi cm ke meter

        $bmi = $weight / ($height * $height);
        $category = $this->getBMICategory($bmi);

        return view('bmi.result', compact('bmi', 'category', 'weight', 'height'));
    }

    private function getBMICategory($bmi)
    {
        if ($bmi < 18.5) {
            return [
                'name' => 'Kurus',
                'description' => 'Berat badan Anda di bawah normal. Konsultasikan dengan dokter untuk meningkatkan berat badan secara sehat.',
                'color' => 'warning'
            ];
        } elseif ($bmi >= 18.5 && $bmi < 25) {
            return [
                'name' => 'Normal',
                'description' => 'Berat badan Anda ideal. Pertahankan pola makan dan gaya hidup sehat.',
                'color' => 'success'
            ];
        } elseif ($bmi >= 25 && $bmi < 30) {
            return [
                'name' => 'Gemuk',
                'description' => 'Berat badan Anda di atas normal. Mulai program penurunan berat badan dengan olahraga dan diet sehat.',
                'color' => 'warning'
            ];
        } else {
            return [
                'name' => 'Obesitas',
                'description' => 'Berat badan Anda sangat tinggi. Segera konsultasikan dengan dokter untuk program penurunan berat badan.',
                'color' => 'danger'
            ];
        }
    }
} 