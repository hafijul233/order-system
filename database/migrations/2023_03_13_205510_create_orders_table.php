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
            $table->string('type')->default('order');
            $table->string('reference_no');
            $table->foreignId('reference_id');
            $table->string('platform')->default('office');
            $table->string('delivery')->nullable();
            $table->text('delivery_comment')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->foreignId('company_id')->nullable()->constrained('companies');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('address_book_id')->nullable()->constrained('address_books');
            $table->unsignedInteger('total_item')->nullable();
            $table->decimal('subtotal', 13, 4)->nullable();
            $table->decimal('discount', 13, 4)->nullable();
            $table->decimal('tax', 13, 4)->nullable();
            $table->decimal('delivery_charge', 13, 4)->nullable();
            $table->decimal('total_amount', 13, 4)->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->foreignId('assignee_id')->nullable()->constrained('users');
            $table->enum('priority', ['lowest','low', 'medium', 'high', 'highest'])->default('medium');
            $table->text('block_reason')->nullable();
            $table->text('note')->nullable();
            $table->text('attachments')->nullable();
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
