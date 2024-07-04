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
        Schema::create('payout_request_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('fund_request_id');
            $table->foreign('fund_request_id')->references('id')->on('fund_requests')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('api_id');
            $table->foreign('api_id')->references('id')->on('apis')->onUpdate('cascade')->onDelete('cascade');
            $table->float('amount',10,2);
            $table->float('charge',10,2);
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('credited_by');
            $table->foreign('credited_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->float('balance',10,2);
            $table->string('type');
            $table->string('transtype')->nullable();
            $table->string('product')->nullable();
            $table->string('remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_request_histories');
    }
};
