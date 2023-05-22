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
        Schema::create('partie_adverses', function (Blueprint $table) {
            $table->id();
            $table->string('nomprénom')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('telephone')->nullable();
            $table->string('adresse')->nullable();
            $table->enum('naturecontractant',[
                'Administration',
                'Collectivités locales',
                'Entreprise public',
                'Entreprise privée',
                'Entreprise étrangère'
            ])->nullable();
            $table->string('tutelletiers')->nullable();
            $table->string('familletiers')->nullable();
            $table->string('groupetiers')->nullable();
            $table->enum('secteurtiers',['Privé','Public'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partie_adverses');
    }
};
