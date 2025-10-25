@extends('layouts.app')

@section('title', 'Daftar Penyakit - Formularium')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-disease me-2"></i>Daftar Penyakit
    </h1>
    @if(auth()->user()->isAdmin())
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('diseases.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Penyakit
        </a>
    </div>
    @endif
</div>

<!-- Search and Filter -->
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('diseases.index') }}" class="row g-3" id="searchForm">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control" id="searchInput" name="search" 
                           value="{{ request('search') }}" placeholder="Cari nama penyakit atau ICD code...">
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select" id="categoryFilter" name="category">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-hashtag"></i>
                    </span>
                    <input type="text" class="form-control" id="icdCodeInput" name="icd_code" 
                           value="{{ request('icd_code') }}" placeholder="ICD Code (contoh: A90.0)">
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Diseases Table -->
<div class="card shadow">
    <div class="card-body">
        @if($diseases->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Penyakit</th>
                            <th>ICD Code</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Gejala</th>
                            <th>Pengobatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($diseases as $disease)
                        <tr>
                            <td>
                                <strong>{{ $disease->name }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $disease->icd_code }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $disease->category }}</span>
                            </td>
                            <td>
                                @if($disease->description)
                                    {{ Str::limit($disease->description, 50) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($disease->symptoms)
                                    {{ Str::limit($disease->symptoms, 50) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($disease->treatment)
                                    {{ Str::limit($disease->treatment, 50) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('diseases.show', $disease) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                    <a href="{{ route('diseases.edit', $disease) }}" 
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('diseases.destroy', $disease) }}" method="POST" 
                                          class="d-inline" onsubmit="return confirm('Yakin ingin menghapus penyakit ini?')">
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
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $diseases->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-disease fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada data penyakit</h5>
                <p class="text-muted">Belum ada penyakit yang ditambahkan ke dalam sistem.</p>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('diseases.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Penyakit Pertama
                </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Statistics -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Penyakit</h6>
                        <h4 class="mb-0">{{ $diseases->total() }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-disease fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Infeksi</h6>
                        <h4 class="mb-0">{{ $diseases->where('category', 'Infeksi')->count() }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-virus fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Kardiovaskular</h6>
                        <h4 class="mb-0">{{ $diseases->where('category', 'Kardiovaskular')->count() }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-heart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Respirasi</h6>
                        <h4 class="mb-0">{{ $diseases->where('category', 'Respirasi')->count() }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-lungs fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
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
    
    document.getElementById('icdCodeInput').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('searchForm').submit();
        }, 500);
    });
    
    // Auto-submit on category change
    document.getElementById('categoryFilter').addEventListener('change', function() {
        document.getElementById('searchForm').submit();
    });
</script>
@endpush