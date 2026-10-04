<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Qriff extends Model
{
    use HasUuids;

    protected $table = 'qriff';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'facility_id', 'product_id', 'opening', 'received', 'issued',
        'physical', 'cases', 'remarks', 'quarter',
    ];

    protected $casts = [
        'opening' => 'decimal:2',
        'received' => 'decimal:2',
        'issued' => 'decimal:2',
        'physical' => 'decimal:2',
        'cases' => 'decimal:2',
    ];
}
