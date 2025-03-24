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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('payment_mode_id');
            $table->foreign('payment_mode_id')->references('id')->on('payment_modes')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('credited_by');
            $table->foreign('credited_by')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->float('amount',10,2);
            $table->string('type');
            $table->date('pay_date');
            $table->string('pay_slip')->nullable();
            $table->string('references_no');
            $table->longText('remark')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses')->constrained()->onUpdate('cascade')->onDelete('cascade');
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
