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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('conversion', 18, 3)->default(1);
            $table->foreignId('parent_id')->nullable()->unique();
            $table->integer('lft')->nullable()->default(0);
            $table->integer('rgt')->nullable()->default(0);
            $table->integer('depth')->nullable()->default(0);
            $table->boolean('enabled')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
