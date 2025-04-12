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
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('dispute_id');
            $table->string('payment_id');
            $table->string('entity');
            $table->float('amount',10,2);
            $table->string('currency');
            $table->float('amount_deducted',10,2);
            $table->string('gateway_dispute_id');
            $table->string('reason_code');
            $table->timestamp('respond_by');
            $table->string('status');
            $table->string('phase');
            $table->text('comments')->nullable();
            $table->timestamp('created_at_razorpay');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};
