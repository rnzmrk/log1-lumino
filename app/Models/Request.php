<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'item_name',
        'quantity',
        'type',
        'description',
        'status',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}
