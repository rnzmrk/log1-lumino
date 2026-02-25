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
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('vehicles', 'brand')) {
                $table->string('brand')->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'type')) {
                $table->string('type')->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'color')) {
                $table->string('color')->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'plate_number')) {
                $table->string('plate_number')->nullable()->unique();
            }
            if (!Schema::hasColumn('vehicles', 'capacity')) {
                $table->integer('capacity')->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'driver')) {
                $table->string('driver')->nullable();
            }
            
            // Update status column if it exists
            if (Schema::hasColumn('vehicles', 'status')) {
                $table->enum('status', ['active', 'maintenance', 'replacement', 'inactive'])->nullable()->default('active')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['brand', 'type', 'color', 'plate_number', 'capacity', 'driver']);
        });
    }
};
