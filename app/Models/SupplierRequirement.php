<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'company_name',
        'years_in_business',
        'business_license',
        'description',
        'admin_notes',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the supplier that owns the requirement
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the business license URL
     */
    public function getBusinessLicenseUrlAttribute()
    {
        return $this->business_license ? asset('storage/' . $this->business_license) : null;
    }
}
