@extends('layouts.app')

@section('title', 'Kalkulator BMI - Formularium')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-calculator me-2"></i>Kalkulator BMI
    </h1>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Body Mass Index Calculator
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('bmi.calculate') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="weight" class="form-label">
                                    <i class="fas fa-weight me-2"></i>Berat Badan (kg)
                                </label>
                                <input type="number" step="0.1" class="form-control @error('weight') is-invalid @enderror" 
                                       id="weight" name="weight" value="{{ old('weight') }}" 
                                       placeholder="Contoh: 65.5" required>
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="height" class="form-label">
                                    <i class="fas fa-ruler-vertical me-2"></i>Tinggi Badan (cm)
                                </label>
                                <input type="number" step="0.1" class="form-control @error('height') is-invalid @enderror" 
                                       id="height" name="height" value="{{ old('height') }}" 
                                       placeholder="Contoh: 170" required>
                                @error('height')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-calculator me-2"></i>Hitung BMI
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-info-circle me-2"></i>Kategori BMI
                                </h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>BMI</th>
                                                <th>Kategori</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>< 18.5</td>
                                                <td>Kurus</td>
                                                <td><span class="badge bg-warning">Berat Badan Kurang</span></td>
                                            </tr>
                                            <tr>
                                                <td>18.5 - 24.9</td>
                                                <td>Normal</td>
                                                <td><span class="badge bg-success">Berat Badan Ideal</span></td>
                                            </tr>
                                            <tr>
                                                <td>25.0 - 29.9</td>
                                                <td>Gemuk</td>
                                                <td><span class="badge bg-warning">Berat Badan Berlebih</span></td>
                                            </tr>
                                            <tr>
                                                <td>≥ 30.0</td>
                                                <td>Obesitas</td>
                                                <td><span class="badge bg-danger">Obesitas</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <strong>Rumus BMI:</strong><br>
                                        BMI = Berat Badan (kg) / (Tinggi Badan (m))²
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tips Section -->
        <div class="card shadow mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>Tips Kesehatan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            <i class="fas fa-utensils fa-2x text-primary mb-2"></i>
                            <h6>Pola Makan Sehat</h6>
                            <small class="text-muted">
                                Konsumsi makanan bergizi seimbang dengan porsi yang tepat
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            <i class="fas fa-running fa-2x text-success mb-2"></i>
                            <h6>Olahraga Teratur</h6>
                            <small class="text-muted">
                                Lakukan aktivitas fisik minimal 30 menit setiap hari
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            <i class="fas fa-bed fa-2x text-info mb-2"></i>
                            <h6>Istirahat Cukup</h6>
                            <small class="text-muted">
                                Tidur 7-8 jam per hari untuk kesehatan optimal
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 