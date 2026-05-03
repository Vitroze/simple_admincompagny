<?php
use App\Models\User;
use App\Models\Ticket;
use App\Models\Dialogue;
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
        Schema::create('dialogue', function (Blueprint $table){
            $table->id();
            $table->string('reponse');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->unique();
            $table->unsignedBigInteger('ticket_id');
            $table->foreign('ticket_id')->references('id')->on('tickets')->unique();
            $table->timestamps();
        });
        Schema::table('dialogue',function(Blueprint $table){
            $table->integer('ticket_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('dialogue');
    }
};
