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
            // Add foreign key if not exists
            if (!Schema::hasColumn('bids', 'request_id')) {
                $table->foreignId('request_id')->constrained()->onDelete('cascade');
            }
            
            // Add missing columns
            if (!Schema::hasColumn('bids', 'supplier_name')) {
                $table->string('supplier_name');
            }
            
            if (!Schema::hasColumn('bids', 'bid_amount')) {
                $table->decimal('bid_amount', 10, 2);
            }
            
            if (!Schema::hasColumn('bids', 'currency')) {
                $table->string('currency', 3)->default('USD');
            }
            
            if (!Schema::hasColumn('bids', 'proposal')) {
                $table->text('proposal')->nullable();
            }
            
            if (!Schema::hasColumn('bids', 'status')) {
                $table->enum('status', ['pending', 'under_review', 'accepted', 'rejected'])->default('pending');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->dropForeign(['request_id']);
            $table->dropColumn(['request_id', 'supplier_name', 'bid_amount', 'currency', 'proposal', 'status']);
        });
    }
};
