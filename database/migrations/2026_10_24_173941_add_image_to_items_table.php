<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // I-check kung wala pa bay image column, dayon duganga
            if (!Schema::hasColumn('items', 'image')) {
                $table->string('image')->nullable()->after('location_lost');
            }
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};