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
        Schema::create('virtual_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('client_account_number');
            $table->string('payment_method');
            $table->float('opening_amount',10,2);
            $table->float('credit_amount',10,2);
            $table->float('closing_amount',10,2);
            $table->string('reference_number');
            $table->string('remitter_name');
            $table->string('remitter_account_number');
            $table->string('remitter_ifsc_code')->nullable();
            $table->string('remitter_bank')->nullable();
            $table->string('remitter_branch')->nullable();
            $table->string('remitter_utr');
            $table->string('credit_account_number');
            $table->string('inward_refernce_number');
            $table->timestamp('credit_time');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtual_requests');
    }
};
