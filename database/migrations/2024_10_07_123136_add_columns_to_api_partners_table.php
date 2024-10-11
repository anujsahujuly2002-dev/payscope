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
        Schema::table('api_partners', function (Blueprint $table) {
            $table->string('company_name')->after('website')->nullable();
            $table->string('company_gst_number')->after('company_name')->nullable();
            $table->string('company_cin_number')->after('company_gst_number')->nullable();
            $table->string('company_pan')->after('company_cin_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('api_partners', function (Blueprint $table) {
            //
        });
    }
};
