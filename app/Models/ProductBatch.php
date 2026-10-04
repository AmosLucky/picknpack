<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBatch extends Model
{
    protected $table = 'product_batches';
    const UPDATED_AT = null;

    protected $fillable = [
        'product_id', 'initiator', 'batch_no', 'expiry_date', 'q_reference',
        'quantity', 'created_at',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'quantity' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function batchData()
    {
        return $this->belongsTo(BatchData::class, 'q_reference');
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'batch_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'batch_id');
    }
}
