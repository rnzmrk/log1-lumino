<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = [
        'request_id',
        'supplier_name',
        'bid_amount',
        'price', // Add price for compatibility
        'bid_date', // Add bid_date for compatibility
        'currency',
        'proposal',
        'status'
    ];

    protected $casts = [
        'bid_amount' => 'decimal:2',
    ];

    public function request()
    {
        return $this->belongsTo(Request::class);
    }
}
