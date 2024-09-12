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
        Schema::create('fund_item_splits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fund_item_id')->constrained()->cascadeOnDelete();
            $table->integer('sequence')->nullable();
            $table->string('description')->nullable();
            $table->integer('amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_item_splits');
    }
};

