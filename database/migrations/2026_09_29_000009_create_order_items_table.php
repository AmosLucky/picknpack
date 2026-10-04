<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orderItems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('product_id');
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->decimal('sent_quantity', 15, 2)->default(0);
            $table->decimal('received_quantity', 15, 2)->default(0);
            $table->string('status');
            $table->timestampTz('created_at')->nullable();
            $table->text('receiver_notes')->nullable();
            $table->timestampTz('updated_at')->nullable();
            $table->timestampTz('cancelled_date')->nullable();
            $table->text('cancellation_reason')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orderItems');
    }
};
