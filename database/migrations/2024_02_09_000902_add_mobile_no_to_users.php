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
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile_no')->after('status')->nullable();
<<<<<<< HEAD
<<<<<<< HEAD
            $table->dateTime('verified_at')->after('mobile_no')->nullable();
            $table->string('otp')->after('verified_at')->nullable();
            $table->timestamp('expire_at')->after('otp')->nullable();
=======
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b
=======
            $table->dateTime('verified_at')->after('mobile_no')->nullable();
            $table->string('otp')->after('verified_at')->nullable();
            $table->timestamp('expire_at')->after('otp')->nullable();
>>>>>>> 8b7da44f6dc739fedf1ba282f33bebafb1b0b89e
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
