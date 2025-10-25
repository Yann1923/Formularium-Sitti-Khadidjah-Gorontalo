@extends('layouts.app')

@section('title', 'Daftar Obat - Formularium')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-pills me-2"></i>Daftar Obat
    </h1>
    @if(auth()->user()->isAdmin())
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('medicines.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Obat
        </a>
    </div>
    @endif
</div>

<!-- Search and Filters -->
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('medicines.index') }}" method="GET" id="searchForm">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari nama obat, generic name..."
                               id="searchInput">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="therapy_class" id="therapyClassFilter">
                        <option value="">Semua Kelas Terapi</option>
                        @foreach($therapyClasses as $class)
                            <option value="{{ $class }}" {{ request('therapy_class') == $class ? 'selected' : '' }}>
                                {{ $class }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="dosage_form" id="formFilter">
                        <option value="">Semua Bentuk Sediaan</option>
                        @foreach($forms as $form)
                            <option value="{{ $form }}" {{ request('dosage_form') == $form ? 'selected' : '' }}>
                                {{ $form }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="restriction" id="restrictionFilter">
                        <option value="">Semua Status</option>
                        <option value="true" {{ request('restriction') === 'true' ? 'selected' : '' }}>Restricted</option>
                        <option value="false" {{ request('restriction') === 'false' ? 'selected' : '' }}>Non-Restricted</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Medicines Table -->
<div class="card shadow">
    <div class="card-body">
        @if($medicines->count() > 0)
            <div class="table-responsive">
                <!-- Desktop View -->
                <table class="table table-hover d-none d-md-table">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Obat</th>
                            <th>Kelas Terapi</th>
                            <th>Sub Kelas</th>
                            <th>Bentuk & Kekuatan</th>
                            <th>Max Prescription</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicines as $medicine)
                        <tr>
                            <td>
                                <strong>{{ $medicine->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $medicine->generic_name }}</small>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $medicine->therapy_class }}</span>
                                @if($medicine->therapy_class_restriction)
                                <br>
                                <small class="text-danger">
                                    <i class="fas fa-exclamation-circle"></i> Restricted
                                </small>
                                @endif
                            </td>
                            <td>{{ $medicine->sub_therapy_class }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $medicine->dosage_form }}</span>
                                <br>
                                <small class="text-muted">{{ $medicine->strength }} {{ $medicine->unit }}</small>
                            </td>
                            <td>{{ $medicine->max_prescription }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('medicines.show', $medicine) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                    <a href="{{ route('medicines.edit', $medicine) }}" 
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('medicines.destroy', $medicine) }}" method="POST" 
                                          class="d-inline" onsubmit="return confirm('Yakin ingin menghapus obat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Mobile View -->
                <div class="d-md-none">
                    <div class="list-group list-group-flush">
                        @foreach($medicines as $medicine)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">{{ $medicine->name }}</h6>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('medicines.show', $medicine) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->isAdmin())
                                        <a href="{{ route('medicines.edit', $medicine) }}" 
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('medicines.destroy', $medicine) }}" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('Yakin ingin menghapus obat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $medicines->links('vendor.pagination.bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-pills fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada data obat</h5>
                <p class="text-muted">Belum ada obat yang ditambahkan ke dalam sistem.</p>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('medicines.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Obat Pertama
                </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection 

@push('scripts')
<script>
    // Live search with debounce
    let searchTimeout;
    document.getElementById('searchInput').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('searchForm').submit();
        }, 500);
    });

    // Auto-submit on filter change
    document.getElementById('therapyClassFilter').addEventListener('change', function() {
        document.getElementById('searchForm').submit();
    });
    
    document.getElementById('formFilter').addEventListener('change', function() {
        document.getElementById('searchForm').submit();
    });
    
    document.getElementById('restrictionFilter').addEventListener('change', function() {
        document.getElementById('searchForm').submit();
    });
</script>
@endpush