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
        Schema::create('expends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fund_id');
            $table->string('title');
            $table->string('proposal_number')->nullable();
            $table->date('proposed_at')->nullable();
            $table->date('approved_at')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('remark')->nullable();
            $table->foreignId('owner_id');
            $table->foreignId('creater_id')->nullable();
            $table->foreignId('updater_id')->nullable();
            $table->boolean('is_locked')->default(false);
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expends');
    }
};
