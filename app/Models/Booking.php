<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'vehicle_id',
        'vehicle_summary',
        'service_package_id',
        'booking_date',
        'time_slot',
        'status',
        'payment_status',
        'payment_method',
        'total_amount',
        'deposit_amount',
        'assigned_technician_id',
        'notes',
        'marketing_source',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date:Y-m-d',
            'total_amount' => 'decimal:2',
            'deposit_amount' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function servicePackage(): BelongsTo
    {
        return $this->belongsTo(ServicePackage::class);
    }

    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(ServiceAddon::class, 'booking_addon')
            ->withPivot('price_at_booking')
            ->withTimestamps();
    }

    public function stagesHistory(): HasMany
    {
        return $this->hasMany(BookingStagesHistory::class)->orderBy('created_at', 'asc');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function assignedTechnician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_technician_id');
    }
}
