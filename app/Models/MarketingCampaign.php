<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subject',
        'type',
        'audience',
        'status',
        'scheduled_at',
        'sent_count',
        'open_rate',
        'click_rate',
        'conversions',
        'revenue_generated',
        'budget',
        'discount_code',
        'body_content',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'open_rate' => 'decimal:2',
            'click_rate' => 'decimal:2',
            'revenue_generated' => 'decimal:2',
            'budget' => 'decimal:2',
            'sent_count' => 'integer',
            'conversions' => 'integer',
        ];
    }
}
