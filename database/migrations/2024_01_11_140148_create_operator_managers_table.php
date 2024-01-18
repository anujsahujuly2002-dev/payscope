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
        Schema::create('operator_managers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('operator_type');
            $table->unsignedBigInteger('api_id');
            $table->foreign('api_id')->references('id')->on('apis')->onDelete('cascade')->onDelete('cascade');
            $table->string('charge_range_start');
            $table->string('charge_range_end');
            $table->enum('status',['0','1'])->comment('0=Inactive,1=active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operator_managers');
    }
};
