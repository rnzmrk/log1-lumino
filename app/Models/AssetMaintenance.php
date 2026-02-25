<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetMaintenance extends Model
{
    use HasFactory;

    protected $table = 'asset_maintenances';

    protected $fillable = [
        'asset_id',
        'maintenance_reason',
        'maintenance_date',
        'status',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the asset that owns the maintenance record.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Get the status badge color class.
     */
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-700',
            'in_progress' => 'bg-blue-100 text-blue-700',
            'completed' => 'bg-green-100 text-green-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Get the formatted status label.
     */
    public function getStatusLabel(): string
    {
        return match($this->status) {
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            default => 'Unknown',
        };
    }
}
