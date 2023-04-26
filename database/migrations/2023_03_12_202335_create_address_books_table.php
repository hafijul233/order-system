<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('address_books', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->morphs('addressable');
            $table->enum('type', array_keys(\App\Models\AddressBook::TYPES))->default('home');
            $table->text('street_address')->nullable();
            $table->string('landmark')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->foreignId('state_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('phone')->nullable();
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
        Schema::dropIfExists('address_books');
    }
};
