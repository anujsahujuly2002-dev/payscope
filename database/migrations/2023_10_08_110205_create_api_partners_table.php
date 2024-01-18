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
        Schema::create('api_partners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('added_by');
            $table->foreign('added_by')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('mobile_no');
            $table->string('address');
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('city');
            $table->bigInteger('pincode');
            $table->string('shop_name');
            $table->string('pancard_no');
            $table->bigInteger('addhar_card');
            $table->unsignedBigInteger('scheme_id');
            $table->foreign('scheme_id')->references('id')->on('schemes')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('website')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_partners');
    }
};
