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
        Schema::table('commissions', function (Blueprint $table) {
            $table->enum('gst',['0','1'])->default('0')->comment('0=No,1=Yes')->after('value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commissions', function (Blueprint $table) {
            //
        });
    }
};
