<?php

use App\Models\User;
use App\Models\Ticket;
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

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('statut');
            $table->date('date_tiket');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->unique();
            $table->timestamps();
        });

        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
