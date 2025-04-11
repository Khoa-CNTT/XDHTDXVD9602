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
        Schema::table('chi_tiet_hoa_don_ban_hangs', function (Blueprint $table) {
            $table->integer('is_che_bien')->default(0);
            $table->integer('is_in_bep')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chi_tiet_hoa_don_ban_hangs', function (Blueprint $table) {
            //
        });
    }
};
