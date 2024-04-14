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
        Schema::table('funds', function (Blueprint $table) {
            $table->float('opening_amount',10,2)->default(0)->after('credited_by');
            $table->float('closing_amount',10,2)->default(0)->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funds', function (Blueprint $table) {
            //
        });
    }
};
