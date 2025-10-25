<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('generic_name', 'like', "%{$search}%")
                  ->orWhere('therapy_class', 'like', "%{$search}%")
                  ->orWhere('sub_therapy_class', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($therapyClass = $request->input('therapy_class')) {
            $query->where('therapy_class', $therapyClass);
        }

        if ($form = $request->input('dosage_form')) {
            $query->where('dosage_form', $form);
        }

        if ($restriction = $request->input('restriction')) {
            $query->where('therapy_class_restriction', $restriction === 'true');
        }

        // Get filter options
        $therapyClasses = Medicine::distinct()->pluck('therapy_class')->filter();
        $forms = Medicine::distinct()->pluck('dosage_form')->filter();

    // Order by therapy class -> sub class -> name for logical grouping
    $medicines = $query->orderBy('therapy_class')
              ->orderBy('sub_therapy_class')
              ->orderBy('name')
              ->paginate(10)
              ->withQueryString();

        return view('medicines.index', compact('medicines', 'therapyClasses', 'forms'));
    }

    public function create()
    {
        return view('medicines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'dosage_form' => 'required|string|max:100',
            'strength' => 'required|string|max:100',
            'manufacturer' => 'required|string|max:255',
            'expiry_date' => 'required|date|after:today',
            'indications' => 'nullable|string',
            'contraindications' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'dosage_instructions' => 'nullable|string',
        ]);

        $medicine = Medicine::create($request->all() + [
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('medicines.index')->with('success', 'Obat berhasil ditambahkan!');
    }

    public function show(Medicine $medicine)
    {
        return view('medicines.show', compact('medicine'));
    }

    public function edit(Medicine $medicine)
    {
        return view('medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'dosage_form' => 'required|string|max:100',
            'strength' => 'required|string|max:100',
            'manufacturer' => 'required|string|max:255',
            'expiry_date' => 'required|date',
            'indications' => 'nullable|string',
            'contraindications' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'dosage_instructions' => 'nullable|string',
        ]);

            $medicine->update($request->all() + [
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('medicines.index')->with('success', 'Obat berhasil diperbarui!');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->route('medicines.index')->with('success', 'Obat berhasil dihapus!');
    }
} 