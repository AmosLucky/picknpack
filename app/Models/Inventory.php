<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';
    public $timestamps = false;

    protected $fillable = [
        'inventory_id', 'product_id', 'batch_id', 'current_quantity', 'last_updated',
    ];

    protected $casts = [
        'current_quantity' => 'decimal:2',
        'last_updated' => 'datetime',
    ];

    public function batch()
    {
        return $this->belongsTo(ProductBatch::class, 'batch_id');
    }
}
