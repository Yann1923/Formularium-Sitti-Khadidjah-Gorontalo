<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Medicine;
use App\Models\Disease;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_medicines' => Medicine::count(),
            'total_diseases' => Disease::count(),
            'total_users' => User::count(),
            'recent_medicines' => Medicine::latest()->take(5)->get(),
            'recent_diseases' => Disease::latest()->take(5)->get(),
        ];

        return view('dashboard', $data);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'address']));

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }
} 