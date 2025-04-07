<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_per_hour',
    ];

    public function timeLogs()
    {
        return $this->hasMany(TimeLog::class);
    }

    public function calculatePriceForHours($hours)
    {
        return $this->price_per_hour * $hours;
    }
} 