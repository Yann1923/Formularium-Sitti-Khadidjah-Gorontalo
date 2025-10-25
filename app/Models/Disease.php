<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icd_code',
        'category',
        'description',
        'symptoms',
        'causes',
        'risk_factors',
        'diagnosis',
        'treatment',
        'prevention',
        'complications',
    ];
    
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class)
                    ->withPivot('dosage', 'notes')
                    ->withTimestamps();

    /**
     * Get the medicines associated with this disease
     */
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class)
                    ->withPivot('dosage', 'notes')
                    ->withTimestamps();

    /**
     * Get the user who created this disease
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this disease
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
} 