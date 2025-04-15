<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'email',
        'website',
        'tax_number',
        'registration_number',
        'logo',
        'is_default',
        'color',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return null;
        }
        
        $url = asset('storage/' . $this->logo);
        return str_replace('http://', 'https://', $url);
    }

    public function getLogoPathAttribute()
    {
        if (!$this->logo) {
            return null;
        }
        
        return storage_path('app/public/' . $this->logo);
    }
} 