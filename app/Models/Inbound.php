<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbound extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'location',
        'storage_location_id',
        'quantity_received',
        'notes',
        'status',
        'created_by',
    ];

    protected $casts = [
        'quantity_received' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'storage_location_id' => 'integer',
    ];

    /**
     * Get the purchase order that owns this inbound shipment.
     */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    /**
     * Get the user who created this inbound shipment.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the storage location for this inbound shipment.
     */
    public function storageLocation()
    {
        return $this->belongsTo(StorageLocation::class);
    }

    /**
     * Get the request associated with this inbound shipment through the purchase order.
     */
    public function request()
    {
        return $this->hasOneThrough(Request::class, PurchaseOrder::class, 'id', 'id', 'purchase_order_id', 'request_id');
    }
}
