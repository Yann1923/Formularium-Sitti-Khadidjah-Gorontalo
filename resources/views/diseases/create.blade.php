@extends('layouts.app')

@section('title', 'Tambah Penyakit - Formularium')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-plus me-2"></i>Tambah Penyakit Baru
    </h1>
    <a href="{{ route('diseases.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-disease me-2"></i>Form Tambah Penyakit
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('diseases.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="name" class="form-label">Nama Penyakit <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="icd_code" class="form-label">ICD Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('icd_code') is-invalid @enderror" 
                                   id="icd_code" name="icd_code" value="{{ old('icd_code') }}" 
                                   placeholder="Contoh: A90.0" required>
                            @error('icd_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Infeksi" {{ old('category') == 'Infeksi' ? 'selected' : '' }}>Infeksi</option>
                                <option value="Kardiovaskular" {{ old('category') == 'Kardiovaskular' ? 'selected' : '' }}>Kardiovaskular</option>
                                <option value="Respirasi" {{ old('category') == 'Respirasi' ? 'selected' : '' }}>Respirasi</option>
                                <option value="Gastrointestinal" {{ old('category') == 'Gastrointestinal' ? 'selected' : '' }}>Gastrointestinal</option>
                                <option value="Neurologi" {{ old('category') == 'Neurologi' ? 'selected' : '' }}>Neurologi</option>
                                <option value="Endokrin" {{ old('category') == 'Endokrin' ? 'selected' : '' }}>Endokrin</option>
                                <option value="Dermatologi" {{ old('category') == 'Dermatologi' ? 'selected' : '' }}>Dermatologi</option>
                                <option value="Ortopedi" {{ old('category') == 'Ortopedi' ? 'selected' : '' }}>Ortopedi</option>
                                <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3" 
                                  placeholder="Deskripsi singkat tentang penyakit...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="symptoms" class="form-label">Gejala</label>
                        <textarea class="form-control @error('symptoms') is-invalid @enderror" 
                                  id="symptoms" name="symptoms" rows="3" 
                                  placeholder="Gejala-gejala yang muncul...">{{ old('symptoms') }}</textarea>
                        @error('symptoms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="causes" class="form-label">Penyebab</label>
                        <textarea class="form-control @error('causes') is-invalid @enderror" 
                                  id="causes" name="causes" rows="3" 
                                  placeholder="Penyebab atau faktor yang menyebabkan penyakit...">{{ old('causes') }}</textarea>
                        @error('causes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="risk_factors" class="form-label">Faktor Risiko</label>
                        <textarea class="form-control @error('risk_factors') is-invalid @enderror" 
                                  id="risk_factors" name="risk_factors" rows="3" 
                                  placeholder="Faktor-faktor yang meningkatkan risiko...">{{ old('risk_factors') }}</textarea>
                        @error('risk_factors')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="diagnosis" class="form-label">Diagnosis</label>
                        <textarea class="form-control @error('diagnosis') is-invalid @enderror" 
                                  id="diagnosis" name="diagnosis" rows="3" 
                                  placeholder="Cara mendiagnosis penyakit...">{{ old('diagnosis') }}</textarea>
                        @error('diagnosis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="treatment" class="form-label">Pengobatan</label>
                        <textarea class="form-control @error('treatment') is-invalid @enderror" 
                                  id="treatment" name="treatment" rows="3" 
                                  placeholder="Cara pengobatan yang disarankan...">{{ old('treatment') }}</textarea>
                        @error('treatment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="prevention" class="form-label">Pencegahan</label>
                        <textarea class="form-control @error('prevention') is-invalid @enderror" 
                                  id="prevention" name="prevention" rows="3" 
                                  placeholder="Cara mencegah penyakit...">{{ old('prevention') }}</textarea>
                        @error('prevention')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="complications" class="form-label">Komplikasi</label>
                        <textarea class="form-control @error('complications') is-invalid @enderror" 
                                  id="complications" name="complications" rows="3" 
                                  placeholder="Komplikasi yang mungkin terjadi...">{{ old('complications') }}</textarea>
                        @error('complications')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Penyakit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 