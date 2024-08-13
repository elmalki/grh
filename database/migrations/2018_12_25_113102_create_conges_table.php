<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCongesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conges', function (Blueprint $table) {
            $table->increments('id');
            $table->date('dateDebut')->nullable();
            $table->date('dateFin')->nullable();
            $table->unsignedInteger('nb_jours')->nullable();
            $table->string('statut')->nullable();
            $table->string('adresse')->nullable();
            $table->string('remplacant')->nullable();

            $table->unsignedInteger('fonctionnaire_id')->nullable();
            $table->foreign('fonctionnaire_id')->references('id')->on('fonctionnaires');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conges');
    }
}
