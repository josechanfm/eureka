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
        Schema::create('budget_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_id');
            $table->foreignId('fund_item_split_id');
            $table->string('description')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('actual')->nullable();
            $table->string('remark')->nullable();
            $table->string('account_code');
            $table->string('reference_code')->nullable();
            $table->foreignId('creator_id')->nullable();
            $table->foreignId('updater_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_items');
    }
};
