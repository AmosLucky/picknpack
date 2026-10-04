<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'orderItems';

    protected $fillable = [
        'order_id', 'product_id', 'batch_id', 'sent_quantity', 'received_quantity',
        'status', 'created_at', 'receiver_notes', 'updated_at', 'cancelled_date',
        'cancellation_reason',
    ];

    protected $casts = [
        'sent_quantity' => 'decimal:2',
        'received_quantity' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'cancelled_date' => 'datetime',
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
