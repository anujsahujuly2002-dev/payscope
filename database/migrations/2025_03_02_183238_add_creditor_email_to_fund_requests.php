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
        Schema::table('fund_requests', function (Blueprint $table) {
            $table->string('creditor_email')->after('ifsc_code')->nullable();
            $table->string('creditor_mobile')->after('creditor_email')->nullable();
            $table->string('quintus_transaction_id')->after('payout_ref')->nullable();
            $table->string('quintus_req_id')->after('quintus_transaction_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fund_requests', function (Blueprint $table) {
            //
        });
    }
};
