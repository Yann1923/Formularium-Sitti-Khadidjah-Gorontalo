@extends('layouts.app')

@section('title', $medicine->name . ' - Detail Obat')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-pills me-2"></i>Detail Obat
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('medicines.edit', $medicine) }}" class="btn btn-warning me-2">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <form action="{{ route('medicines.destroy', $medicine) }}" method="POST" class="d-inline" 
              onsubmit="return confirm('Yakin ingin menghapus obat ini?')">
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
                        <label class="form-label fw-bold">Nama Obat</label>
                        <p class="mb-0">{{ $medicine->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Generic Name</label>
                        <p class="mb-0">{{ $medicine->generic_name }}</p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <p class="mb-0">
                            <span class="badge bg-secondary">{{ $medicine->category }}</span>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Dosage Form</label>
                        <p class="mb-0">{{ $medicine->dosage_form }}</p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Strength</label>
                        <p class="mb-0">{{ $medicine->strength }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Manufacturer</label>
                        <p class="mb-0">{{ $medicine->manufacturer }}</p>
                    </div>
                </div>
                
                @if($medicine->description)
                <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <p class="mb-0">{{ $medicine->description }}</p>
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
                @if($medicine->indications)
                <div class="mb-3">
                    <label class="form-label fw-bold">Indikasi</label>
                    <p class="mb-0">{{ $medicine->indications }}</p>
                </div>
                @endif
                
                @if($medicine->contraindications)
                <div class="mb-3">
                    <label class="form-label fw-bold">Kontraindikasi</label>
                    <p class="mb-0">{{ $medicine->contraindications }}</p>
                </div>
                @endif
                
                @if($medicine->side_effects)
                <div class="mb-3">
                    <label class="form-label fw-bold">Efek Samping</label>
                    <p class="mb-0">{{ $medicine->side_effects }}</p>
                </div>
                @endif
                
                @if($medicine->dosage_instructions)
                <div class="mb-3">
                    <label class="form-label fw-bold">Petunjuk Penggunaan</label>
                    <p class="mb-0">{{ $medicine->dosage_instructions }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Sidebar Information -->
    <div class="col-lg-4">
        <!-- Created/Updated Info -->
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>Informasi Sistem
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Dibuat Oleh</label>
                    <p class="mb-0">
                        @if($medicine->createdBy)
                            {{ $medicine->createdBy->name }}
                        @else
                            <span class="text-muted">Tidak diketahui</span>
                        @endif
                    </p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Terakhir Diupdate</label>
                    <p class="mb-0">
                        @if($medicine->updatedBy)
                            {{ $medicine->updatedBy->name }}
                        @else
                            <span class="text-muted">Tidak diketahui</span>
                        @endif
                    </p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Dibuat</label>
                    <p class="mb-0">{{ $medicine->created_at->format('d F Y H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Terakhir Diupdate</label>
                    <p class="mb-0">{{ $medicine->updated_at->format('d F Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 