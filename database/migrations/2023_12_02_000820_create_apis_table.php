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
        Schema::create('apis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('username');
            $table->string('password');
            $table->string('optional');
            $table->string('code');
            $table->string('type');
            $table->enum('status',['0','1'])->comment('0=InActive','1=Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apis');
    }
};
