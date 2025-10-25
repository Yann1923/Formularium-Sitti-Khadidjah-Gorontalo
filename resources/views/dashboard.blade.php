@extends('layouts.app')

@section('title', 'Dashboard - Formularium')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <span class="text-muted">Selamat datang, {{ auth()->user()->name }}!</span>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Obat
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_medicines }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-pills fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Penyakit
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_diseases }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-disease fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Pengguna
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_users }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Data -->
<div class="row">
    <!-- Recent Medicines -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-pills me-2"></i>Obat Terbaru
                </h6>
                <a href="{{ route('medicines.index') }}" class="btn btn-sm btn-primary">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body">
                @if($recent_medicines->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Obat</th>
                                    <th>Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_medicines as $medicine)
                                <tr>
                                    <td>
                                        <a href="{{ route('medicines.show', $medicine) }}" class="text-decoration-none">
                                            {{ $medicine->name }}
                                        </a>
                                    </td>
                                    <td>{{ $medicine->category }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Belum ada data obat</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Diseases -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-disease me-2"></i>Penyakit Terbaru
                </h6>
                <a href="{{ route('diseases.index') }}" class="btn btn-sm btn-primary">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body">
                @if($recent_diseases->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Penyakit</th>
                                    <th>Kategori</th>
                                    <th>ICD Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_diseases as $disease)
                                <tr>
                                    <td>
                                        <a href="{{ route('diseases.show', $disease) }}" class="text-decoration-none">
                                            {{ $disease->name }}
                                        </a>
                                    </td>
                                    <td>{{ $disease->category }}</td>
                                    <td>{{ $disease->icd_code }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Belum ada data penyakit</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('bmi.index') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-calculator me-2"></i>Kalkulator BMI
                        </a>
                    </div>
                    @if(auth()->user()->isAdmin())
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('medicines.create') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-plus me-2"></i>Tambah Obat
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('diseases.create') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-plus me-2"></i>Tambah Penyakit
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('users.create') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-user-plus me-2"></i>Tambah Pengguna
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 