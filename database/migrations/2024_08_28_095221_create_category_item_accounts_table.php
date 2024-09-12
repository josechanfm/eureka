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
        Schema::create('category_item_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_item_id');
            $table->string('name_zh');
            $table->string('name_en')->nullable();
            $table->string('name_pt')->nullable();
            $table->boolean('user_define');
            $table->string('account_code');
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_item_accounts');
    }
};
