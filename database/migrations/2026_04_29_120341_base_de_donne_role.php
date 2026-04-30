<?php
use App\Models\Droit;
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
        //
        Schema::dropIfExists('droit');
        Schema::create('droit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('ticket')->default(false);
            $table->boolean('gerer_user')->default(false);
            $table->boolean('inventaire')->default(false);
            $table->boolean('gerer_facture')->default(false);
            $table->boolean('parametre')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('droit');
    }
};



