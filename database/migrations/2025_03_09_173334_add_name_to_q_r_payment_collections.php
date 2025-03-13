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
        Schema::table('q_r_payment_collections', function (Blueprint $table) {
            $table->string('email')->after('name');
            $table->string('mobile_no')->after('email');
            $table->enum('payment_channel',['axis-razorpay','phone-pe'])->default('axis-razorpay')->after('payment_type');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('q_r_payment_collections', function (Blueprint $table) {
            //
        });
    }
};
