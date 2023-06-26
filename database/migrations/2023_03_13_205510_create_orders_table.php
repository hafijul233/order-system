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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->default('office');
            $table->string('delivery')->default('delivery');
            $table->text('delivery_comment')->nullable();
            $table->foreignId('customer_id');
            $table->foreignId('company_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('address_book_id')->nullable();
            $table->unsignedBigInteger('total_item')->nullable();
            $table->decimal('subtotal', 18, 5)->nullable();
            $table->decimal('discount', 18, 5)->nullable();
            $table->decimal('tax', 18, 5)->nullable();
            $table->decimal('delivery_charge', 18, 5)->nullable();
            $table->decimal('total_amount', 18, 5)->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->foreignId('assignee_id')->nullable();
            $table->enum('priority', ['lowest','low', 'medium', 'high', 'highest'])->default('medium');
            $table->text('block_reason')->nullable();
            $table->text('note')->nullable();
            $table->timestamp('ordered_at')->nullable()->useCurrent();
            $table->timestamp('delivered_at')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('statuses');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
