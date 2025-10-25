@extends('layouts.app')

@section('title', 'Profil - Formularium')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user me-2"></i>Profil Pengguna
    </h1>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Edit Profil
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">Role</label>
                            <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Akun
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="avatar-circle mx-auto mb-3">
                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                    </div>
                    <h5>{{ $user->name }}</h5>
                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }} mb-2">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-envelope text-muted me-3"></i>
                            <div>
                                <small class="text-muted">Email</small>
                                <div>{{ $user->email }}</div>
                            </div>
                        </div>
                    </div>
                    
                    @if($user->phone)
                    <div class="col-12 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-phone text-muted me-3"></i>
                            <div>
                                <small class="text-muted">Telepon</small>
                                <div>{{ $user->phone }}</div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($user->address)
                    <div class="col-12 mb-3">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-map-marker-alt text-muted me-3 mt-1"></i>
                            <div>
                                <small class="text-muted">Alamat</small>
                                <div>{{ $user->address }}</div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="col-12">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar text-muted me-3"></i>
                            <div>
                                <small class="text-muted">Bergabung Sejak</small>
                                <div>{{ $user->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 