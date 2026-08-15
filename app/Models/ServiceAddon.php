<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ServiceAddon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'icon_name',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booking_addon')
            ->withPivot('price_at_booking')
            ->withTimestamps();
    }
}
