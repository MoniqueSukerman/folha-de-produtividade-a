<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GratitudeItem extends Model
{
    protected $fillable = [
        'daily_sheet_id',
        'description',
        'order_number',
    ];

    public function dailySheet(): BelongsTo
    {
        return $this->belongsTo(DailySheet::class);
    }
} 