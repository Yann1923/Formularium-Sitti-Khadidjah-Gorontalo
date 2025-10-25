@extends('layouts.app')

@section('title', $disease->name . ' - Detail Penyakit')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-disease me-2"></i>Detail Penyakit
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('diseases.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('diseases.edit', $disease) }}" class="btn btn-warning me-2">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <form action="{{ route('diseases.destroy', $disease) }}" method="POST" class="d-inline" 
              onsubmit="return confirm('Yakin ingin menghapus penyakit ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash me-2"></i>Hapus
            </button>
        </form>
        @endif
    </div>
</div>

<div class="row">
    <!-- Basic Information -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Penyakit</label>
                        <p class="mb-0">{{ $disease->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">ICD Code</label>
                        <p class="mb-0">
                            <span class="badge bg-info">{{ $disease->icd_code }}</span>
                        </p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <p class="mb-0">
                            <span class="badge bg-secondary">{{ $disease->category }}</span>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <p class="mb-0">
                            <span class="badge bg-success">Aktif</span>
                        </p>
                    </div>
                </div>
                
                @if($disease->description)
                <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <p class="mb-0">{{ $disease->description }}</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Medical Information -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-stethoscope me-2"></i>Informasi Medis
                </h5>
            </div>
            <div class="card-body">
                @if($disease->symptoms)
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>Gejala
                    </label>
                    <p class="mb-0">{{ $disease->symptoms }}</p>
                </div>
                @endif
                
                @if($disease->causes)
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-search text-info me-2"></i>Penyebab
                    </label>
                    <p class="mb-0">{{ $disease->causes }}</p>
                </div>
                @endif
                
                @if($disease->risk_factors)
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-exclamation-circle text-danger me-2"></i>Faktor Risiko
                    </label>
                    <p class="mb-0">{{ $disease->risk_factors }}</p>
                </div>
                @endif
                
                @if($disease->diagnosis)
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-microscope text-primary me-2"></i>Diagnosis
                    </label>
                    <p class="mb-0">{{ $disease->diagnosis }}</p>
                </div>
                @endif
                
                @if($disease->treatment)
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-pills text-success me-2"></i>Pengobatan
                    </label>
                    <p class="mb-0">{{ $disease->treatment }}</p>
                </div>
                @endif
                
                <!-- Daftar Obat Terkait -->
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-prescription-bottle-alt text-primary me-2"></i>Obat yang Direkomendasikan
                    </label>
                    @if($disease->medicines->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>Dosis</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($disease->medicines as $medicine)
                                    <tr>
                                        <td>
                                            <a href="{{ route('medicines.show', $medicine) }}" class="text-decoration-none">
                                                {{ $medicine->name }}
                                            </a>
                                        </td>
                                        <td>{{ $medicine->pivot->dosage }}</td>
                                        <td>{{ $medicine->pivot->notes }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">Belum ada obat yang terdaftar untuk penyakit ini.</p>
                    @endif
                </div>
                
                @if($disease->prevention)
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-shield-alt text-info me-2"></i>Pencegahan
                    </label>
                    <p class="mb-0">{{ $disease->prevention }}</p>
                </div>
                @endif
                
                @if($disease->complications)
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-exclamation-triangle text-danger me-2"></i>Komplikasi
                    </label>
                    <p class="mb-0">{{ $disease->complications }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Sidebar Information -->
    <div class="col-lg-4">
        <!-- Disease Info Card -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Informasi Penyakit
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="disease-icon mb-3">
                        @switch($disease->category)
                            @case('Infeksi')
                                <i class="fas fa-virus fa-4x text-danger"></i>
                                @break
                            @case('Kardiovaskular')
                                <i class="fas fa-heart fa-4x text-danger"></i>
                                @break
                            @case('Respirasi')
                                <i class="fas fa-lungs fa-4x text-info"></i>
                                @break
                            @case('Gastrointestinal')
                                <i class="fas fa-stomach fa-4x text-warning"></i>
                                @break
                            @case('Neurologi')
                                <i class="fas fa-brain fa-4x text-primary"></i>
                                @break
                            @case('Endokrin')
                                <i class="fas fa-seedling fa-4x text-success"></i>
                                @break
                            @default
                                <i class="fas fa-disease fa-4x text-secondary"></i>
                        @endswitch
                    </div>
                    <h5>{{ $disease->name }}</h5>
                    <span class="badge bg-secondary mb-2">{{ $disease->category }}</span>
                    <br>
                    <span class="badge bg-info">{{ $disease->icd_code }}</span>
                </div>
                
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar text-muted me-3"></i>
                            <div>
                                <small class="text-muted">Tanggal Input</small>
                                <div>{{ $disease->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user text-muted me-3"></i>
                            <div>
                                <small class="text-muted">Dibuat Oleh</small>
                                <div>
                                    @if($disease->createdBy)
                                        {{ $disease->createdBy->name }}
                                    @else
                                        <span class="text-muted">Tidak diketahui</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-edit text-muted me-3"></i>
                            <div>
                                <small class="text-muted">Terakhir Diupdate</small>
                                <div>{{ $disease->updated_at->format('d M Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('medicines.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-pills me-2"></i>Cari Obat Terkait
                    </a>
                    <a href="{{ route('bmi.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-calculator me-2"></i>Kalkulator BMI
                    </a>
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('diseases.edit', $disease) }}" class="btn btn-outline-warning">
                        <i class="fas fa-edit me-2"></i>Edit Penyakit
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Information -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6 class="alert-heading">
                        <i class="fas fa-lightbulb me-2"></i>Tips Kesehatan
                    </h6>
                    <p class="mb-0">
                        Informasi ini hanya sebagai referensi. Untuk diagnosis dan pengobatan yang tepat, 
                        konsultasikan dengan dokter atau tenaga medis profesional.
                    </p>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6>Kapan Harus ke Dokter:</h6>
                        <ul>
                            <li>Gejala semakin memburuk</li>
                            <li>Demam tinggi yang tidak turun</li>
                            <li>Kesulitan bernapas</li>
                            <li>Nyeri yang tidak tertahankan</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Pencegahan Umum:</h6>
                        <ul>
                            <li>Menjaga kebersihan diri</li>
                            <li>Makan makanan bergizi</li>
                            <li>Olahraga teratur</li>
                            <li>Istirahat yang cukup</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 