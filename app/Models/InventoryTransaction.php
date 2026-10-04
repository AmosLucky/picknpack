<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    protected $table = 'inventory_transactions';
    const UPDATED_AT = null;

    protected $fillable = [
        'initiator_id', 'counterpart_id', 'product_id', 'order_id', 'batch_id',
        'transaction_type', 'quantity_change', 'transaction_date', 'user_id',
        'notes', 'created_at',
    ];

    protected $casts = [
        'quantity_change' => 'decimal:2',
        'transaction_date' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function batch()
    {
        return $this->belongsTo(ProductBatch::class, 'batch_id');
    }
}
