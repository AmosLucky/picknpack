<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batch_data', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_summary_id');
            $table->string('batch_no');
            $table->date('expiry_date');
            $table->decimal('quantity', 15, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batch_data');
    }
};
