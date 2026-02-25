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
        Schema::table('bids', function (Blueprint $table) {
            // Add price column if it doesn't exist (for compatibility with existing table)
            if (!Schema::hasColumn('bids', 'price')) {
                $table->decimal('price', 10, 2)->nullable();
            }
            
            // Add bid_date column if it doesn't exist (for compatibility with existing table)
            if (!Schema::hasColumn('bids', 'bid_date')) {
                $table->date('bid_date')->nullable();
            }
            
            // Make sure all required columns exist
            if (!Schema::hasColumn('bids', 'request_id')) {
                $table->foreignId('request_id')->nullable()->constrained()->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('bids', 'supplier_name')) {
                $table->string('supplier_name')->nullable();
            }
            
            if (!Schema::hasColumn('bids', 'bid_amount')) {
                $table->decimal('bid_amount', 10, 2)->nullable();
            }
            
            if (!Schema::hasColumn('bids', 'currency')) {
                $table->string('currency', 3)->default('USD')->nullable();
            }
            
            if (!Schema::hasColumn('bids', 'proposal')) {
                $table->text('proposal')->nullable();
            }
            
            if (!Schema::hasColumn('bids', 'status')) {
                $table->enum('status', ['pending', 'under_review', 'accepted', 'rejected'])->default('pending')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->dropColumn(['price', 'bid_date', 'request_id', 'supplier_name', 'bid_amount', 'currency', 'proposal', 'status']);
        });
    }
};
