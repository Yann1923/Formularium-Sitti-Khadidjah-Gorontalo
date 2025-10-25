@extends('layouts.app')

@section('title', 'Kelola Pengguna - Formularium')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-users me-2"></i>Kelola Pengguna
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Pengguna
        </a>
    </div>
</div>

<!-- Search and Filter -->
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('users.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari Pengguna</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Nama atau email...">
            </div>
            <div class="col-md-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="apoteker" {{ request('role') == 'apoteker' ? 'selected' : '' }}>Apoteker</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card shadow">
    <div class="card-body">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Bergabung</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        <i class="fas fa-user-circle fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        @if($user->id === auth()->id())
                                            <br><small class="text-muted">(Anda)</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                @if($user->phone)
                                    {{ $user->phone }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($user->address)
                                    {{ Str::limit($user->address, 30) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-success">Aktif</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('users.edit', $user) }}" 
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" 
                                          class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
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
                {{ $users->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada data pengguna</h5>
                <p class="text-muted">Belum ada pengguna yang ditambahkan ke dalam sistem.</p>
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Pengguna Pertama
                </a>
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
                        <h6 class="card-title">Total Pengguna</h6>
                        <h4 class="mb-0">{{ $users->total() }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Admin</h6>
                        <h4 class="mb-0">{{ $users->where('role', 'admin')->count() }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-shield fa-2x"></i>
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
                        <h6 class="card-title">Apoteker</h6>
                        <h4 class="mb-0">{{ $users->where('role', 'apoteker')->count() }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-md fa-2x"></i>
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
                        <h6 class="card-title">Aktif</h6>
                        <h4 class="mb-0">{{ $users->count() }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('users.create') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-user-plus me-2"></i>Tambah Admin
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('users.create') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-user-plus me-2"></i>Tambah Apoteker
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('medicines.index') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-pills me-2"></i>Kelola Obat
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('diseases.index') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-disease me-2"></i>Kelola Penyakit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 