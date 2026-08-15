<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServicePackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tagline',
        'slug',
        'category',
        'description',
        'duration_hours',
        'price_sedan',
        'price_coupe',
        'price_suv',
        'price_truck',
        'price_exotic',
        'warranty',
        'badge',
        'popular',
        'features',
        'before_image',
        'after_image',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'popular' => 'boolean',
            'duration_hours' => 'integer',
            'price_sedan' => 'decimal:2',
            'price_coupe' => 'decimal:2',
            'price_suv' => 'decimal:2',
            'price_truck' => 'decimal:2',
            'price_exotic' => 'decimal:2',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
