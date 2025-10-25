<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Disease;

class DiseaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Disease::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('icd_code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        // ICD Code filter
        if ($icdCode = $request->input('icd_code')) {
            $query->where('icd_code', 'like', "%{$icdCode}%");
        }

        // Get unique categories for filter
        $categories = Disease::distinct()->pluck('category')->filter();
        
        $diseases = $query->latest()->paginate(10)->withQueryString();
        
        return view('diseases.index', compact('diseases', 'categories'));
    }

    public function create()
    {
        return view('diseases.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icd_code' => 'required|string|max:20|unique:diseases',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'symptoms' => 'nullable|string',
            'causes' => 'nullable|string',
            'risk_factors' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'prevention' => 'nullable|string',
            'complications' => 'nullable|string',
        ]);

        $disease = Disease::create($request->all() + [
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('diseases.index')->with('success', 'Penyakit berhasil ditambahkan!');
    }

    public function show(Disease $disease)
    {
        return view('diseases.show', compact('disease'));
    }

    public function edit(Disease $disease)
    {
        return view('diseases.edit', compact('disease'));
    }

    public function update(Request $request, Disease $disease)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icd_code' => 'required|string|max:20|unique:diseases,icd_code,' . $disease->id(),
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'symptoms' => 'nullable|string',
            'causes' => 'nullable|string',
            'risk_factors' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'prevention' => 'nullable|string',
            'complications' => 'nullable|string',
        ]);

        $disease->update($request->all() + [
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('diseases.index')->with('success', 'Penyakit berhasil diperbarui!');
    }

    public function destroy(Disease $disease)
    {
        $disease->delete();
        return redirect()->route('diseases.index')->with('success', 'Penyakit berhasil dihapus!');
    }
} 