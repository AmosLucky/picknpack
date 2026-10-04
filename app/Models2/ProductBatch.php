<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBatch extends Model
{
    protected $table = 'product_batches';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'initiator',
        'batch_no',
        'expiry_date',
        'q_reference',
        'quantity',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'quantity'    => 'decimal:2',
    ];

    /**
     * Inventory records belonging to this batch.
     */
    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'batch_id', 'id');
    }
}