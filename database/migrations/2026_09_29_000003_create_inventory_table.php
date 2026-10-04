<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('inventory_id');
            $table->string('product_id');
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->decimal('current_quantity', 15, 2)->default(0);
            $table->timestampTz('last_updated')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
