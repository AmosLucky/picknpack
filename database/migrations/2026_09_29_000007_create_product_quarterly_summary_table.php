<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_quarterly_summary', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('facility_id');
            $table->string('product_id');
            $table->string('quarter');
            $table->decimal('opening', 15, 2)->default(0);
            $table->decimal('received', 15, 2)->default(0);
            $table->decimal('issued', 15, 2)->default(0);
            $table->text('remarks')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_quarterly_summary');
    }
};
