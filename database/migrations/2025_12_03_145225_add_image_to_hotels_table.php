<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // No-op: column `image` already exists in production, avoid duplicate column errors.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: keep existing schema as-is.
    }
};
