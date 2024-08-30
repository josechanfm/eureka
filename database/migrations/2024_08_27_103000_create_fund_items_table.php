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
        Schema::create('fund_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fund_id');
            $table->string('category_item_id');
            $table->string('description')->nullable();
            $table->string('account_code')->nullable();
            $table->string('sequence')->nullable();
            $table->string('amount')->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_items');
    }
};
