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
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            //TODO : Ajouter la colonne follower_id (clé étrangère vers users)
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            //TODO : Ajouter la colonne user_id (clé étrangère vers users)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            //TODO: Empêcher qu'un même follower suive plusieurs fois le même utilisateur
            $table->unique(['follower_id', 'user_id']); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
