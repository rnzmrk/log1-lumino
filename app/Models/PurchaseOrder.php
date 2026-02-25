<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'supplier',
        'price',
        'expected_delivery_date',
        'notes',
        'status',
    ];

    protected $casts = [
        'expected_delivery_date' => 'date',
        'price' => 'integer',
    ];

    /**
     * Get the request that owns the purchase order.
     */
    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    /**
     * Get the inbound shipment for this purchase order.
     */
    public function inbound()
    {
        return $this->hasOne(Inbound::class);
    }

    /**
     * Scope to get POs by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
