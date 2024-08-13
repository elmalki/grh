<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFonctionnairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fonctionnaires', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cin')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', ['Homme', 'Femme'])->nullable();
            $table->enum('situationFamilliale', ['Célibataire', 'Marié(e)','Divorcé(e)','Veuf(ve)'])->nullable();
            $table->enum('niveau', ['Primaire', 'Collégial','Secondaire','Universitaire','Magistral','Doctoral'])->nullable();
            $table->date('dateNaissance')->nullable();
            $table->date('dateRecrutement')->nullable();
            $table->string('lieuNaissance')->nullable();
            $table->string('adresseResidence')->nullable();
            $table->string('adresseCourrier')->nullable();
            $table->string('tel1')->nullable();
            $table->string('tel2')->nullable();
            $table->string('email')->nullable();
            $table->string('rib')->nullable();
            $table->string('agence')->nullable();
            $table->string('ville')->nullable();
            $table->string('password');
            $table->unsignedInteger('solde_conge')->default(0);
            $table->string('statut')->nullable();
            $table->string('description')->nullable();
            $table->rememberToken();
            $table->unsignedInteger('division_id');
            $table->unsignedInteger('grade_id');
            $table->unsignedInteger('profil_id')->nullable();
            $table->timestamps();

            $table->foreign('division_id')->references('id')->on('divisions');
            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('profil_id')->references('id')->on('profils');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fonctionnaires');
    }
}
