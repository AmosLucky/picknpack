<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_batches', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->string('initiator');
            $table->string('batch_no');
            $table->date('expiry_date');
            $table->uuid('q_reference')->nullable();
            $table->decimal('quantity', 15, 2)->default(0);
            $table->timestampTz('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_batches');
    }
};
