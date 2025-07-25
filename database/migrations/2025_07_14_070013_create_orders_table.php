<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 10, 3);
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled', 'refunded'])
                  ->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('unpaid');
            $table->text('shipping_address')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Add indexes
            $table->index('user_id');
            $table->index('order_number');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};