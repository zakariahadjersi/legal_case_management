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
        Schema::create('dossier_justices', function (Blueprint $table) {
            $table->id();
            $table->string('code_affaire')->default('');
            $table->enum('state',[
                'en préparation',
                'inspection de travail',
                'au tribunal',
                'à la cour',
                'à la cour suprême',
                'Gagné',
                'Perdu',
            ])->nullable();
            $table->enum('secteur',[
                'Personnel',
                'Commerciale'
            ])->nullable();
            $table->bigInteger('budget')->nullable();
            $table->date('date_fin')->nullable();
            $table->integer('user_id')->unsigned()->default(0);
            $table->integer('avocat_id')->unsigned()->nullable();
            $table->integer('agence_id')->unsigned()->nullable();
            $table->integer('partie_adverse_id')->unsigned()->nullable();      
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossier_justices');
    }
};
