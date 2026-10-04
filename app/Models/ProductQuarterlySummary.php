<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProductQuarterlySummary extends Model
{
    use HasUuids;

    protected $table = 'product_quarterly_summary';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'facility_id', 'product_id', 'quarter', 'opening', 'received', 'issued', 'remarks',
    ];

    protected $casts = [
        'opening' => 'decimal:2',
        'received' => 'decimal:2',
        'issued' => 'decimal:2',
    ];

    public function batchData()
    {
        return $this->hasMany(BatchData::class, 'product_summary_id');
    }
}
