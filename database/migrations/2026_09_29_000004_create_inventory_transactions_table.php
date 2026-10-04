<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('initiator_id');
            $table->string('counterpart_id');
            $table->string('product_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->string('transaction_type');
            $table->decimal('quantity_change', 15, 2);
            $table->timestampTz('transaction_date')->nullable();
            $table->string('user_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestampTz('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
