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
        Schema::create('q_r_payment_collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('qr_code_id');
            $table->string('entity');
            $table->string('name');
            $table->string('usage');
            $table->string('type');
            $table->string('image_url');
            $table->string('payment_amount');
            $table->string('qr_status');
            $table->string('description');
            $table->enum('fixed_amount',['0','1'])->comment('0=no,1=yes');
            $table->string('payments_amount_received');
            $table->string('payments_count_received');
            $table->dateTime('qr_close_at'); 
            $table->dateTime('qr_created_at');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses')->onUpdate('cascade')->onDelete('cascade');  
            $table->dateTime('close_by')->nullable();
            $table->string('close_reason')->nullable();        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('q_r_payment_collections');
    }
};
