<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'inbound_id',
        'quantity',
        'status',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the inbound shipment that owns this inventory.
     */
    public function inbound()
    {
        return $this->belongsTo(Inbound::class);
    }
}
