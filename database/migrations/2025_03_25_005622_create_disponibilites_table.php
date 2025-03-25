<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisponibilitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disponibilites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menthor_id')->constrained()->onDelete('cascade'); // Référence à la table 'menthors'
            $table->string('jour'); // Jour de la disponibilité
            $table->time('heure_debut'); // Heure de début
            $table->time('heure_fin'); // Heure de fin
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disponibilites');
    }
}
