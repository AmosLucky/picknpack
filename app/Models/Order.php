<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    const CREATED_AT = null;

    protected $fillable = [
        'sender_facility_id', 'receiver_facility_id', 'order_type', 'status',
        'created_by', 'sent_date', 'confirmed_date', 'cancelled_date',
        'cancellation_reason', 'updated_at',
    ];

    protected $casts = [
        'sent_date' => 'datetime',
        'confirmed_date' => 'datetime',
        'cancelled_date' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class, 'order_id');
    }
}
