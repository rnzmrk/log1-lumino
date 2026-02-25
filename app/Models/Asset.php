<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';

    protected $fillable = [
        'inventory_id',
        'quantity',
        'duration',
        'department',
        'status',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'duration' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the inventory item that owns the asset.
     */
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Get the status badge color class.
     */
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-700',
            'maintenance' => 'bg-amber-100 text-amber-700',
            'replacement' => 'bg-purple-100 text-purple-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Get the formatted status label.
     */
    public function getStatusLabel(): string
    {
        return match($this->status) {
            'active' => 'Active',
            'maintenance' => 'Maintenance',
            'replacement' => 'Replacement',
            default => 'Unknown',
        };
    }

    /**
     * Get the item name through inventory relationship.
     */
    public function getItemNameAttribute(): string
    {
        return $this->inventory?->inbound?->purchaseOrder?->request?->item_name ?? 'Unknown Item';
    }

    /**
     * Get the item type through inventory relationship.
     */
    public function getItemTypeAttribute(): string
    {
        return $this->inventory?->inbound?->purchaseOrder?->request?->type ?? 'unknown';
    }

    /**
     * Get the location through inventory relationship.
     */
    public function getLocationAttribute(): string
    {
        return $this->inventory?->inbound?->storageLocation?->name ?? 'N/A';
    }
}
