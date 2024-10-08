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
            $table->string('email')->nullable()->unique()->after('mobile_no');
            $table->string('company_address')->after('address');
            $table->string('company_name')->after('shop_name');
            $table->string('brand_name')->after('company_name');
            $table->string('gst')->after('brand_name');
            $table->string('cin_number')->after('gst');
            $table->string('company_pan')->after('cin_number');
            $table->bigInteger('company_adhaarcard')->after('addhar_card');

            $table->unsignedBigInteger('company_state_id')->after('company_adhaarcard');
            $table->foreign('company_state_id')->references('id')->on('states')->onUpdate('cascade')->onDelete('cascade');

            $table->string('company_city')->after('company_state_id');
            $table->bigInteger('company_pincode')->after('company_city');
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
