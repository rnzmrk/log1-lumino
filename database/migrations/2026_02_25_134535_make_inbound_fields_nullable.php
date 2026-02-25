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
        Schema::table('inbounds', function (Blueprint $table) {
            $table->integer('quantity_received')->nullable()->change();
            $table->foreignId('storage_location_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inbounds', function (Blueprint $table) {
            $table->integer('quantity_received')->nullable(false)->change();
            $table->foreignId('storage_location_id')->nullable(false)->change();
        });
    }
};
