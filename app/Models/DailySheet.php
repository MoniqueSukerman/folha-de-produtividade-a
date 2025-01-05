<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DailySheet extends Model
{
    protected $fillable = [
        'date',
        'daily_focus',
        'day_rating',
        'learned_today',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function priorities(): HasMany
    {
        return $this->hasMany(Priority::class)->orderBy('order_number');
    }

    public function avoidItems(): HasMany
    {
        return $this->hasMany(AvoidItem::class)->orderBy('order_number');
    }

    public function gratitudeItems(): HasMany
    {
        return $this->hasMany(GratitudeItem::class)->orderBy('order_number');
    }
} 