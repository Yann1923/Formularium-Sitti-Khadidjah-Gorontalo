@extends('layouts.app')

@section('title', 'Edit Obat - Formularium')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-edit me-2"></i>Edit Obat
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        <a href="{{ route('medicines.show', $medicine) }}" class="btn btn-outline-primary">
            <i class="fas fa-eye me-2"></i>Lihat Detail
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-pills me-2"></i>Form Edit Obat
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('medicines.update', $medicine) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Informasi Dasar -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Dasar</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nama Obat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $medicine->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="generic_name" class="form-label">Nama Generik <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('generic_name') is-invalid @enderror" 
                                           id="generic_name" name="generic_name" value="{{ old('generic_name', $medicine->generic_name) }}" required>
                                    @error('generic_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="therapy_class" class="form-label">Kelas Terapi</label>
                                    <input type="text" class="form-control @error('therapy_class') is-invalid @enderror" 
                                           id="therapy_class" name="therapy_class" value="{{ old('therapy_class', $medicine->therapy_class) }}">
                                    @error('therapy_class')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="sub_therapy_class" class="form-label">Sub Kelas Terapi</label>
                                    <input type="text" class="form-control @error('sub_therapy_class') is-invalid @enderror" 
                                           id="sub_therapy_class" name="sub_therapy_class" value="{{ old('sub_therapy_class', $medicine->sub_therapy_class) }}">
                                    @error('sub_therapy_class')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Antibiotik" {{ old('category', $medicine->category) == 'Antibiotik' ? 'selected' : '' }}>Antibiotik</option>
                                        <option value="Analgesik" {{ old('category', $medicine->category) == 'Analgesik' ? 'selected' : '' }}>Analgesik</option>
                                        <option value="Antipiretik" {{ old('category', $medicine->category) == 'Antipiretik' ? 'selected' : '' }}>Antipiretik</option>
                                        <option value="Antiseptik" {{ old('category', $medicine->category) == 'Antiseptik' ? 'selected' : '' }}>Antiseptik</option>
                                        <option value="Antihistamin" {{ old('category', $medicine->category) == 'Antihistamin' ? 'selected' : '' }}>Antihistamin</option>
                                        <option value="Antasida" {{ old('category', $medicine->category) == 'Antasida' ? 'selected' : '' }}>Antasida</option>
                                        <option value="Vitamin" {{ old('category', $medicine->category) == 'Vitamin' ? 'selected' : '' }}>Vitamin</option>
                                        <option value="Lainnya" {{ old('category', $medicine->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="manufacturer" class="form-label">Pabrikan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('manufacturer') is-invalid @enderror" 
                                           id="manufacturer" name="manufacturer" value="{{ old('manufacturer', $medicine->manufacturer) }}" required>
                                    @error('manufacturer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Sediaan -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-pills me-2"></i>Informasi Sediaan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="dosage_form" class="form-label">Bentuk Sediaan <span class="text-danger">*</span></label>
                                    <select class="form-select @error('dosage_form') is-invalid @enderror" id="dosage_form" name="dosage_form" required>
                                        <option value="">Pilih Bentuk</option>
                                        <option value="Tablet" {{ old('dosage_form', $medicine->dosage_form) == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                                        <option value="Kapsul" {{ old('dosage_form', $medicine->dosage_form) == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                                        <option value="Sirup" {{ old('dosage_form', $medicine->dosage_form) == 'Sirup' ? 'selected' : '' }}>Sirup</option>
                                        <option value="Salep" {{ old('dosage_form', $medicine->dosage_form) == 'Salep' ? 'selected' : '' }}>Salep</option>
                                        <option value="Injeksi" {{ old('dosage_form', $medicine->dosage_form) == 'Injeksi' ? 'selected' : '' }}>Injeksi</option>
                                        <option value="Drops" {{ old('dosage_form', $medicine->dosage_form) == 'Drops' ? 'selected' : '' }}>Drops</option>
                                        <option value="Lainnya" {{ old('dosage_form', $medicine->dosage_form) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('dosage_form')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="strength" class="form-label">Kekuatan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('strength') is-invalid @enderror" 
                                           id="strength" name="strength" value="{{ old('strength', $medicine->strength) }}" required>
                                    @error('strength')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <input type="text" class="form-control @error('satuan') is-invalid @enderror" 
                                           id="satuan" name="satuan" value="{{ old('satuan', $medicine->satuan) }}" 
                                           placeholder="mg, ml, g, dll">
                                    @error('satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="peresepan_maksimal" class="form-label">Peresepan Maksimal</label>
                                    <input type="number" class="form-control @error('peresepan_maksimal') is-invalid @enderror" 
                                           id="peresepan_maksimal" name="peresepan_maksimal" 
                                           value="{{ old('peresepan_maksimal', $medicine->peresepan_maksimal) }}"
                                           placeholder="Jumlah maksimal yang dapat diresepkan">
                                    @error('peresepan_maksimal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="restriksi_kelas_terapi" class="form-label">Restriksi Kelas Terapi</label>
                                    <input type="text" class="form-control @error('restriksi_kelas_terapi') is-invalid @enderror" 
                                           id="restriksi_kelas_terapi" name="restriksi_kelas_terapi" 
                                           value="{{ old('restriksi_kelas_terapi', $medicine->restriksi_kelas_terapi) }}"
                                           placeholder="Batasan penggunaan berdasarkan kelas terapi">
                                    @error('restriksi_kelas_terapi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Informasi Tambahan -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Informasi Tambahan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="expiry_date" class="form-label">Tanggal Kedaluwarsa <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" 
                                           id="expiry_date" name="expiry_date" value="{{ old('expiry_date', $medicine->expiry_date->format('Y-m-d')) }}" required>
                                    @error('expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3"
                                          placeholder="Deskripsi umum tentang obat ini...">{{ old('description', $medicine->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Klinis -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-stethoscope me-2"></i>Informasi Klinis</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="indications" class="form-label">Indikasi</label>
                                <textarea class="form-control @error('indications') is-invalid @enderror" 
                                          id="indications" name="indications" rows="3" 
                                          placeholder="Untuk apa obat ini digunakan...">{{ old('indications', $medicine->indications) }}</textarea>
                                @error('indications')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="contraindications" class="form-label">Kontraindikasi</label>
                                <textarea class="form-control @error('contraindications') is-invalid @enderror" 
                                          id="contraindications" name="contraindications" rows="3" 
                                          placeholder="Kondisi yang tidak boleh menggunakan obat ini...">{{ old('contraindications', $medicine->contraindications) }}</textarea>
                                @error('contraindications')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="side_effects" class="form-label">Efek Samping</label>
                                <textarea class="form-control @error('side_effects') is-invalid @enderror" 
                                          id="side_effects" name="side_effects" rows="3" 
                                          placeholder="Efek samping yang mungkin terjadi...">{{ old('side_effects', $medicine->side_effects) }}</textarea>
                                @error('side_effects')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="dosage_instructions" class="form-label">Petunjuk Penggunaan</label>
                                <textarea class="form-control @error('dosage_instructions') is-invalid @enderror" 
                                          id="dosage_instructions" name="dosage_instructions" rows="3" 
                                          placeholder="Cara penggunaan obat...">{{ old('dosage_instructions', $medicine->dosage_instructions) }}</textarea>
                                @error('dosage_instructions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Obat
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Current Medicine Info -->
        <div class="card shadow mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Obat Saat Ini
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-calendar text-muted me-3"></i>
                            <div>
                                <small class="text-muted">Dibuat Pada</small>
                                <div>{{ $medicine->created_at->format('d F Y H:i') }}</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-user text-muted me-3"></i>
                            <div>
                                <small class="text-muted">Dibuat Oleh</small>
                                <div>
                                    @if($medicine->createdBy)
                                        {{ $medicine->createdBy->name }}
                                    @else
                                        <span class="text-muted">Tidak diketahui</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-clock text-muted me-3"></i>
                            <div>
                                <small class="text-muted">Terakhir Diupdate</small>
                                <div>{{ $medicine->updated_at->format('d F Y H:i') }}</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-edit text-muted me-3"></i>
                            <div>
                                <small class="text-muted">Diupdate Oleh</small>
                                <div>
                                    @if($medicine->updatedBy)
                                        {{ $medicine->updatedBy->name }}
                                    @else
                                        <span class="text-muted">Tidak diketahui</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Set minimum date to today for expiry date
    document.getElementById('expiry_date').min = new Date().toISOString().split('T')[0];
</script>
@endpush 