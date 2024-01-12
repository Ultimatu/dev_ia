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
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->foreignId("groupe_id")->constrained("groupes")->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("teacher_id")->constrained("enseignants")->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("local_id")->constrained("locaux")->onDelete("cascade")->onUpdate("cascade");
            $table->date('date_cours');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours');
    }
};
