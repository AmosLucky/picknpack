<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('sender_facility_id');
            $table->string('receiver_facility_id');
            $table->string('order_type');
            $table->string('status');
            $table->string('created_by');
            $table->timestampTz('sent_date')->nullable();
            $table->timestampTz('confirmed_date')->nullable();
            $table->timestampTz('cancelled_date')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestampTz('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
