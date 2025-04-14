<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TimeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'date',
        'hours',
        'rate',
        'location',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'hours' => 'decimal:2',
        'rate' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class, 'invoice_time_logs')
            ->withTimestamps();
    }

    public function getTotalPriceAttribute()
    {
        return $this->service->calculatePriceForHours($this->hours);
    }
} 