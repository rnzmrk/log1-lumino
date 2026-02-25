<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemReturn extends Model
{
    protected $table = 'returns';
    
    protected $fillable = [
        'inventory_id',
        'quantity',
        'reason',
        'status',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the inventory that owns this return.
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
}
