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
            $table->string('utr_number')->after('close_reason')->nullable();
            $table->string('payer_name')->after('utr_number')->nullable();
            $table->string('payment_id')->after('payer_name')->nullable();
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
