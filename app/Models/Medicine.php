<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'therapy_class',
        'sub_therapy_class',
        'generic_name',
        'category',
        'sediaan',
        'kekuatan',
        'satuan',
        'peresepan_maksimal',
        'restriksi_kelas_terapi',
        'description',
        'dosage_form',
        'strength',
        'manufacturer',
        'expiry_date',
        'indications',
        'contraindications',
        'side_effects',
        'dosage_instructions',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    /**
     * Get the user who created this medicine
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this medicine
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
} 