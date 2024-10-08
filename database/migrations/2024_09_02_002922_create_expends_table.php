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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->char('year',4);
            $table->foreignId('fund_id');
            $table->string('title');
            $table->string('proposal_number')->nullable();
            $table->date('proposed_at')->nullable();
            $table->string('proposed_by')->nullable();
            $table->date('approved_at')->nullable();
            $table->string('remark')->nullable();
            $table->foreignId('owner_id');
            $table->foreignId('creator_id')->nullable();
            $table->foreignId('updater_id')->nullable();
            $table->char('status',2)->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
