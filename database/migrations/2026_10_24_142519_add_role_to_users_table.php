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
            // Gidugang nato ang role field para sa User Management[cite: 2]
            $table->string('role')->default('Student'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tangtangon kini kung i-rollback ang migration[cite: 2]
            $table->dropColumn('role'); 
        });
    }
};