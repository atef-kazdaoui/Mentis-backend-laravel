<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('rendez_vous', function (Blueprint $table) {
        $table->id();
        $table->foreignId('menthor_id')->constrained('menthors')->onDelete('cascade');
        $table->foreignId('menthorer_id')->constrained('menthorers')->onDelete('cascade');
        $table->dateTime('date_heure');
        $table->integer('duree'); // durée en minutes par exemple
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vous');
    }
};
