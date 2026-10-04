<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qriff', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('facility_id');
            $table->string('product_id');
            $table->decimal('opening', 15, 2)->default(0);
            $table->decimal('received', 15, 2)->default(0);
            $table->decimal('issued', 15, 2)->default(0);
            $table->decimal('physical', 15, 2)->default(0);
            $table->decimal('cases', 15, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->string('quarter');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qriff');
    }
};
