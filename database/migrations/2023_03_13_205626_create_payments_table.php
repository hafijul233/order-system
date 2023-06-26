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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->foreignId('order_id')->nullable()->constrained('orders');
            $table->foreignId('payment_option_id')->nullable()->constrained('payment_options');
            $table->decimal('amount', 13, 4)->nullable();
            $table->decimal('due', 13, 4)->nullable();
            $table->string('installment_type')->default('full')->comment('full/partial/pending');
            $table->json('data')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('statuses');
            $table->text('notes')->nullable();
            $table->text('attachments')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
