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
            $table->string('code_affaire');
            $table->string('state');
            $table->string('secteur');
            $table->float('budget')->nullable();
            $table->date('date_fin')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('avocat_id')->unsigned();
            $table->integer('agence_id')->unsigned();
            $table->integer('partie_adverse_id')->unsigned();      
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
