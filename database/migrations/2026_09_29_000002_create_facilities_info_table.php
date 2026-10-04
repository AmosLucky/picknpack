<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilities_info', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('zone')->nullable();
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->string('name')->nullable();
            $table->string('inventory_id')->nullable();
            $table->string('facility_type')->nullable();
            $table->timestampTz('date_updated')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilities_info');
    }
};
