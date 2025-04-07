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
        'default_price',
    ];

    public function timeLogs()
    {
        return $this->hasMany(TimeLog::class);
    }
} 