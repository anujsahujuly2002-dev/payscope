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
            $table->enum('is_payment_settel',['0','1'])->default(0)->comment('0=no,1=yes')->after('close_reason');
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
