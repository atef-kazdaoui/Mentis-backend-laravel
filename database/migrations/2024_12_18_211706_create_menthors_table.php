    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenthorsTable extends Migration
{
    public function up()
    {
        Schema::create('menthors', function (Blueprint $table) {
            $table->id();  // ID auto-incrémenté
            $table->string('nom');  // Nom obligatoire
            $table->string('prenom');  // Prénom obligatoire
            $table->string('email')->unique();  // Email unique
            $table->string('password');
            $table->string('numero_siret')->nullable()->unique(); // Numero SIRET unique et nullable
            $table->integer('score')->nullable();  // Score nullable
            $table->text('commentaire')->nullable();  // Commentaire nullable
            $table->integer('annee_experience')->nullable();  // Année d'expérience nullable
            $table->string('role')->default('menthor');
            $table->timestamps();  // created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('menthors');
    }
}
