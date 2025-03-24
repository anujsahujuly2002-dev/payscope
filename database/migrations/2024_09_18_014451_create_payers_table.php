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
        Schema::create('payers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->float('limit_per_transaction',10,2)->default(0);
            $table->float('limit_total',10,2)->default(0);
            $table->float('limit_consumed',10,2)->default(0);
            $table->float('limit_available',10,2)->default(0);
            $table->enum('limit_increase_offer',[0,1])->default(0);
            $table->enum('allow_profile_update',[0,1])->default(0);
            $table->float('maximum_daily_limit',10,2)->default(0);
            $table->float('consumed_daily_limit',10,2)->default(0);
            $table->float('available_daily_limit',10,2)->default(0);
            $table->float('maximum_monthly_limit',10,2)->default(0);
            $table->float('consumed_monthly_limit',10,2)->default(0);
            $table->float('available_monthly_limit',10,2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payers');
    }
};
