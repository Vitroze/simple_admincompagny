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
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create("permissions", function (Blueprint $table) {
            $table->id();
            $table->string('name_permission');
            $table->timestamps();
        });

        Schema::create("rank_permission", function (Blueprint $table) {
            $table->id();
            $table->foreignId('rank_id')->constrained('ranks')->onDelete('cascade');
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rank_permission');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('ranks');
    }
};
