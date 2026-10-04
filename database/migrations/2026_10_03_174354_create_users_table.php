<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            // User identity
            $table->id();

            $table->string('name');

            $table->string('email')->unique();

            $table->string('password');

            // Only: national, zone, state
            $table->enum('role', [
                'national',
                'zone',
                'state',
            ]);

            // Geographic scope
            $table->string('region')->nullable();

            $table->string('zone')->nullable();

            $table->string('state')->nullable();

            $table->string('lga')->nullable();

            // Store this account operates
            $table->string('store_id')->nullable();

            // Contact
            $table->string('phone')->nullable();

            // Account status
            $table->boolean('is_active')->default(true);

            // Laravel authentication
            $table->timestamp('email_verified_at')->nullable();

            $table->timestamp('last_login_at')->nullable();

            $table->rememberToken();

            $table->timestamps();

            // Indexes
            $table->index('role');
            $table->index('region');
            $table->index('zone');
            $table->index('state');
            $table->index('store_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};