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
        Schema::create('transfer_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->string('transaction_type'); // e.g., "deposit", "withdrawal"
            $table->decimal('amount', 15, 2); // Supports large financial values
            $table->text('remark')->nullable(); // Optional remarks
            $table->string('utr_number')->nullable(); // Unique Transaction Reference
            $table->string('reference_number')->nullable(); // General tracking number
            $table->string('transaction_id')->unique(); // Unique transaction identifier
            $table->unsignedBigInteger('status')->default(1);
            $table->foreign('status')->references('id')->on('statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_returns');
    }
};
