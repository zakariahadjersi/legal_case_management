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
        Schema::create('audiences', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('heur')->nullable();
            $table->enum('typecourt', [
                'Inspection De Travail',
                'Le Tribunal',
                'La Cour',
                'La Cour Supreme'
            ]);
            $table->enum('resultat',[
                'succès',
                'perdu',
                'reporter'
            ])->nullable();
            $table->json('files')->nullable();
            $table->integer('dossier_justice_id')->unsigned()->nullable();
            $table->integer('court_id')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audiences');
    }
};
