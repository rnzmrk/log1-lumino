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
        Schema::table('vehicles', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('vehicles', 'vehicle_type')) {
                $table->string('vehicle_type', 100)->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'brand')) {
                $table->string('brand', 255)->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'model')) {
                $table->string('model', 255)->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'license_plate')) {
                $table->string('license_plate', 20)->nullable()->unique();
            }
            if (!Schema::hasColumn('vehicles', 'capacity')) {
                $table->integer('capacity')->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'color')) {
                $table->string('color', 50)->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'driver')) {
                $table->string('driver', 255)->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'status')) {
                $table->enum('status', ['active', 'maintenance', 'replacement', 'inactive'])->nullable()->default('active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['vehicle_type', 'brand', 'model', 'license_plate', 'capacity', 'color', 'driver', 'status']);
        });
    }
};
