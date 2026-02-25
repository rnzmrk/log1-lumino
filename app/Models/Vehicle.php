<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number',
        'type',
        'year',
        'brand',
        'color',
        'capacity',
        'driver',
        'status',
    ];

    protected $casts = [
        'capacity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Helper method for status badge
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'active' => '<span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Active</span>',
            'maintenance' => '<span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">Maintenance</span>',
            'replacement' => '<span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-700">Replacement</span>',
            'inactive' => '<span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Inactive</span>',
            default => '<span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Active</span>',
        };
    }

    // Helper method for formatted vehicle ID
    public function getFormattedIdAttribute()
    {
        return '#VHL' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }
}
