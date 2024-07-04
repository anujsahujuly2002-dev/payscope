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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scheme_id');
            $table->foreign('scheme_id')->references('id')->on('schemes')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('slab_id');
            $table->foreign('slab_id')->references('id')->on('operator_managers')->onDelete('cascade')->onUpdate('cascade');
            $table->string('operator');
            $table->enum('type',['0','1'])->comment('0=Percent,1=Flat');
            $table->string('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
