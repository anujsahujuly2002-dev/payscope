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
            $table->float('charge',10,2)->after('payments_amount_received')->default('0');
            $table->float('gst',10,2)->after('charge')->default('0');
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
