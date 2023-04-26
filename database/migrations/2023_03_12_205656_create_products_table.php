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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->json('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->nullable();
            $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->string('weight')->nullable();
            $table->decimal('default_quantity', 18,3)->default(1);
            $table->enum('platform', ['online', 'offline', 'both'])->default('offline');
            $table->enum('type', ['normal', 'bundle'])->default('normal');
            $table->decimal('cost',19, 4)->default(0);
            $table->decimal('price',19, 4)->default(0);
            $table->decimal('reorder_level', 18,3)->default(1);
            $table->boolean('inventory_enabled')->default(true);
            $table->text('block_reason')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('products');
    }
};
