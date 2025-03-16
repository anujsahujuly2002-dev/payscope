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
        Schema::table('razorap_event_histories', function (Blueprint $table) {
            $table->enum('payment_channel',['axis-razorpay','phone-pe'])->default('axis-razorpay')->after('event');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('razorap_event_histories', function (Blueprint $table) {
            //
        });
    }
};
