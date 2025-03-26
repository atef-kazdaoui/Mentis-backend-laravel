<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menthorer_id')->constrained('menthorers')->onDelete('cascade');
            $table->foreignId('menthor_id')->constrained('menthors')->onDelete('cascade');
            $table->text('contenu');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commentaires');
    }
};

