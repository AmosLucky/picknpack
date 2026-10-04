<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class FacilitiesInfo extends Model
{
    use HasUuids;

    protected $table = 'facilities_info';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'zone', 'state', 'lga', 'name', 'inventory_id', 'facility_type', 'date_updated',
    ];

    protected $casts = [
        'date_updated' => 'datetime',
    ];
}
