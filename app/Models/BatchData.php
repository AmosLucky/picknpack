<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BatchData extends Model
{
    use HasUuids;

    protected $table = 'batch_data';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'product_summary_id', 'batch_no', 'expiry_date', 'quantity',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'quantity' => 'decimal:2',
    ];

    public function productSummary()
    {
        return $this->belongsTo(ProductQuarterlySummary::class, 'product_summary_id');
    }
}
