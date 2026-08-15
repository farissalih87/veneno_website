<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingStagesHistory extends Model
{
    use HasFactory;

    protected $table = 'booking_stages_histories';

    protected $fillable = [
        'booking_id',
        'stage',
        'notes',
        'photo_url',
        'created_by',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
