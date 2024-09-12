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
        Schema::create('expend_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expend_id');
            $table->foreignId('fund_item_split_id');
            $table->string('description')->nullable();
            $table->integer('amount');
            $table->string('remark')->nullable();
            $table->foreignId('creater_id')->nullable();
            $table->foreignId('updater_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expend_items');
    }
};
