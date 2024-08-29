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
        Schema::create('funds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fund_category_id');
            $table->string('entity');
            $table->string('declarant');
            $table->string('birm')->nullable();
            $table->string('project_code')->nullable();
            $table->string('title')->nullable();
            $table->string('responsible')->nullable();
            $table->string('amount')->nullable();
            $table->string('type')->nullable();
            $table->string('duration')->nullable();
            $table->string('grant')->nullable();
            $table->string('repayment')->nullable();
            $table->string('grants')->default('[]');
            $table->string('repayments')->nullable('[]');
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funds');
    }
};
