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
        Schema::create('auto_transaction_update_webhook_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('fund_requests')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('webhook_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_transaction_update_webhook_models');
    }
};
