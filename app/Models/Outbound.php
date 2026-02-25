<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outbound extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'name',
        'quantity',
        'location',
        'status',
        'ship_date',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'ship_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the inventory that owns this outbound shipment.
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Get the inbound shipment associated through inventory.
     */
    public function inbound()
    {
        return $this->hasOneThrough(Inbound::class, Inventory::class, 'id', 'id', 'inventory_id', 'inbound_id');
    }

    /**
     * Scope to get outbounds by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
