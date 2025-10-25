@extends('layouts.app')

@section('title', 'Hasil BMI - Formularium')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-calculator me-2"></i>Hasil Perhitungan BMI
    </h1>
    <a href="{{ route('bmi.index') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- BMI Result Card -->
        <div class="card shadow mb-4">
            <div class="card-header text-center">
                <h4 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>Hasil Perhitungan
                </h4>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6 mb-4">
                        <div class="border rounded p-4">
                            <h3 class="text-primary">{{ number_format($bmi, 1) }}</h3>
                            <p class="mb-0 text-muted">BMI Anda</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="border rounded p-4">
                            <h3 class="text-{{ $category['color'] }}">{{ $category['name'] }}</h3>
                            <p class="mb-0 text-muted">Kategori</p>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-{{ $category['color'] }} text-center">
                    <h5 class="alert-heading">{{ $category['name'] }}</h5>
                    <p class="mb-0">{{ $category['description'] }}</p>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-weight me-2"></i>Data Input
                                </h6>
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">Berat Badan</small>
                                        <div class="fw-bold">{{ $weight }} kg</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Tinggi Badan</small>
                                        <div class="fw-bold">{{ $height * 100 }} cm</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-calculator me-2"></i>Perhitungan
                                </h6>
                                <small class="text-muted">BMI = {{ $weight }} / ({{ number_format($height, 2) }})²</small><br>
                                <small class="text-muted">BMI = {{ $weight }} / {{ number_format($height * $height, 2) }}</small><br>
                                <small class="text-muted">BMI = {{ number_format($bmi, 1) }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- BMI Scale -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Skala BMI
                </h5>
            </div>
            <div class="card-body">
                <div class="progress mb-3" style="height: 30px;">
                    <div class="progress-bar bg-warning" style="width: 18.5%">
                        <small>Kurus</small>
                    </div>
                    <div class="progress-bar bg-success" style="width: 6.4%">
                        <small>Normal</small>
                    </div>
                    <div class="progress-bar bg-warning" style="width: 5%">
                        <small>Gemuk</small>
                    </div>
                    <div class="progress-bar bg-danger" style="width: 70.1%">
                        <small>Obesitas</small>
                    </div>
                </div>
                
                <div class="row text-center">
                    <div class="col-3">
                        <small class="text-muted">0</small>
                    </div>
                    <div class="col-3">
                        <small class="text-muted">18.5</small>
                    </div>
                    <div class="col-3">
                        <small class="text-muted">25</small>
                    </div>
                    <div class="col-3">
                        <small class="text-muted">30</small>
                    </div>
                    <div class="col-3">
                        <small class="text-muted">40+</small>
                    </div>
                </div>
                
                <!-- Current Position Indicator -->
                <div class="text-center mt-3">
                    @php
                        $position = 0;
                        if ($bmi < 18.5) {
                            $position = ($bmi / 18.5) * 18.5;
                        } elseif ($bmi < 25) {
                            $position = 18.5 + (($bmi - 18.5) / 6.5) * 6.4;
                        } elseif ($bmi < 30) {
                            $position = 24.9 + (($bmi - 25) / 5) * 5;
                        } else {
                            $position = 29.9 + (($bmi - 30) / 10) * 70.1;
                        }
                    @endphp
                    <div class="position-relative">
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar" style="width: {{ min($position, 100) }}%"></div>
                        </div>
                        <div class="position-absolute" style="left: {{ min($position, 100) }}%; top: -5px;">
                            <i class="fas fa-arrow-up text-danger"></i>
                        </div>
                    </div>
                    <small class="text-muted">Posisi BMI Anda: {{ number_format($bmi, 1) }}</small>
                </div>
            </div>
        </div>
        
        <!-- Recommendations -->
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>Rekomendasi
                </h5>
            </div>
            <div class="card-body">
                @if($category['name'] === 'Kurus')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <h6 class="card-title text-warning">
                                        <i class="fas fa-utensils me-2"></i>Pola Makan
                                    </h6>
                                    <ul class="mb-0">
                                        <li>Konsumsi makanan berkalori tinggi</li>
                                        <li>Makan lebih sering (5-6x sehari)</li>
                                        <li>Pilih makanan bergizi seimbang</li>
                                        <li>Tambah asupan protein</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-info">
                                <div class="card-body">
                                    <h6 class="card-title text-info">
                                        <i class="fas fa-dumbbell me-2"></i>Olahraga
                                    </h6>
                                    <ul class="mb-0">
                                        <li>Latihan kekuatan (strength training)</li>
                                        <li>Fokus pada pembentukan otot</li>
                                        <li>Hindari olahraga kardio berlebihan</li>
                                        <li>Konsultasi dengan trainer</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($category['name'] === 'Normal')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card border-success">
                                <div class="card-body">
                                    <h6 class="card-title text-success">
                                        <i class="fas fa-check-circle me-2"></i>Pertahankan
                                    </h6>
                                    <ul class="mb-0">
                                        <li>Jaga pola makan seimbang</li>
                                        <li>Olahraga teratur 3-4x seminggu</li>
                                        <li>Monitor berat badan rutin</li>
                                        <li>Hidup sehat dan aktif</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-heart me-2"></i>Pencegahan
                                    </h6>
                                    <ul class="mb-0">
                                        <li>Hindari makanan berlemak berlebihan</li>
                                        <li>Kontrol porsi makan</li>
                                        <li>Istirahat cukup</li>
                                        <li>Kelola stres dengan baik</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <h6 class="card-title text-warning">
                                        <i class="fas fa-utensils me-2"></i>Pola Makan
                                    </h6>
                                    <ul class="mb-0">
                                        <li>Kurangi asupan kalori</li>
                                        <li>Pilih makanan rendah lemak</li>
                                        <li>Perbanyak sayur dan buah</li>
                                        <li>Hindari makanan cepat saji</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-info">
                                <div class="card-body">
                                    <h6 class="card-title text-info">
                                        <i class="fas fa-running me-2"></i>Olahraga
                                    </h6>
                                    <ul class="mb-0">
                                        <li>Kardio 30-45 menit setiap hari</li>
                                        <li>Latihan kekuatan 2-3x seminggu</li>
                                        <li>Mulai dengan intensitas rendah</li>
                                        <li>Konsultasi dengan dokter</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="alert alert-info mt-3">
                    <h6 class="alert-heading">
                        <i class="fas fa-info-circle me-2"></i>Penting!
                    </h6>
                    <p class="mb-0">
                        Hasil ini hanya sebagai referensi. Untuk diagnosis dan pengobatan yang tepat, 
                        konsultasikan dengan dokter atau ahli gizi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 