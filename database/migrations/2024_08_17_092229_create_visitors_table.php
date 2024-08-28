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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('lastName')->nullable();
            $table->string('status')->nullable();
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->string('telegram')->nullable();
            $table->string('email')->nullable();
            $table->string('category')->nullable();
            $table->boolean('isRejected')->default(false);
            $table->string('code')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
