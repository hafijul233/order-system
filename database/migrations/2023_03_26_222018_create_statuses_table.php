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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->morphs('statusable');
            $table->string('icon')->comment('line awesome icon class name');
            $table->string('name');
            $table->string('code')->comment('slug format of status');
            $table->text('description')->nullable();
            $table->foreignId('parent_id')->nullable()->default(0);
            $table->integer('lft')->nullable()->default(0);
            $table->integer('rgt')->nullable()->default(0);
            $table->integer('depth')->nullable()->default(0);
            $table->boolean('is_default')->default(false);
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
