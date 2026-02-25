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
            // Modify existing columns to be nullable
            $table->string('brand')->nullable()->change();
            $table->string('type')->nullable()->change();
            $table->string('color')->nullable()->change();
            $table->string('plate_number')->nullable()->change();
            
            // Update status enum to include 'inactive' and make nullable
            $table->enum('status', ['active', 'maintenance', 'replacement', 'inactive'])->nullable()->default('active')->change();
            
            // Add capacity column if it doesn't exist
            if (!Schema::hasColumn('vehicles', 'capacity')) {
                $table->integer('capacity')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('brand')->nullable(false)->change();
            $table->string('type')->nullable(false)->change();
            $table->string('color')->nullable(false)->change();
            $table->string('plate_number')->nullable(false)->change();
            $table->enum('status', ['active', 'maintenance', 'replacement'])->default('replacement')->change();
            $table->dropColumn('capacity');
        });
    }
};
