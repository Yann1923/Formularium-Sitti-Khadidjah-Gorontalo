<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BMIController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    
    // Medicines (Read-only for apoteker, CRUD for admin)
    Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines.index');
    Route::get('/medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
    Route::get('/medicines/{medicine}', [MedicineController::class, 'show'])->name('medicines.show');
    
    // Diseases (Read-only for apoteker, CRUD for admin)
    Route::get('/diseases', [DiseaseController::class, 'index'])->name('diseases.index');
    Route::get('/diseases/create', [DiseaseController::class, 'create'])->name('diseases.create');
    Route::get('/diseases/{disease}', [DiseaseController::class, 'show'])->name('diseases.show');
    
    // BMI Calculator
    Route::get('/bmi', [BMIController::class, 'index'])->name('bmi.index');
    Route::post('/bmi/calculate', [BMIController::class, 'calculate'])->name('bmi.calculate');
    
    // Admin-only routes
    Route::middleware('admin')->group(function () {
        // Medicines CRUD
        Route::get('/medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
        Route::post('/medicines', [MedicineController::class, 'store'])->name('medicines.store');
        Route::get('/medicines/{medicine}/edit', [MedicineController::class, 'edit'])->name('medicines.edit');
        Route::put('/medicines/{medicine}', [MedicineController::class, 'update'])->name('medicines.update');
        Route::delete('/medicines/{medicine}', [MedicineController::class, 'destroy'])->name('medicines.destroy');
        
        // Diseases CRUD
        Route::get('/diseases/create', [DiseaseController::class, 'create'])->name('diseases.create');
        Route::post('/diseases', [DiseaseController::class, 'store'])->name('diseases.store');
        Route::get('/diseases/{disease}/edit', [DiseaseController::class, 'edit'])->name('diseases.edit');
        Route::put('/diseases/{disease}', [DiseaseController::class, 'update'])->name('diseases.update');
        Route::delete('/diseases/{disease}', [DiseaseController::class, 'destroy'])->name('diseases.destroy');
        
        // Users Management
        Route::resource('users', UserController::class);
    });
});
