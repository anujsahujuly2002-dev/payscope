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
        Schema::table('login_sessions', function (Blueprint $table) {
            $table->enum('login_source',['0','1'])->comment('0=Web,1=Mobile')->default('0')->after('is_logged_in');
<<<<<<< HEAD
            $table->integer('login_device')->default('0')->after('login_source');
=======
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('login_sessions', function (Blueprint $table) {
            //
        });
    }
};
