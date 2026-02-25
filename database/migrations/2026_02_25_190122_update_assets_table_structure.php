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
        Schema::table('assets', function (Blueprint $table) {
            // Drop the old inbound_id foreign key and column if it exists
            if (Schema::hasColumn('assets', 'inbound_id')) {
                $table->dropForeign(['inbound_id']);
                $table->dropColumn('inbound_id');
            }
            
            // Add inventory_id if it doesn't exist
            if (!Schema::hasColumn('assets', 'inventory_id')) {
                $table->foreignId('inventory_id')->after('id')->constrained()->onDelete('cascade');
            }
            
            // Add quantity if it doesn't exist
            if (!Schema::hasColumn('assets', 'quantity')) {
                $table->integer('quantity')->after('inventory_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
