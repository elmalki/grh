<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('dateDepart')->nullable();
            $table->dateTime('dateArrive')->nullable();
            $table->longText('compteRendu')->nullable();
            $table->longText('observations')->nullable();
            $table->longText('instructions_sg')->nullable();
            $table->longText('instructions_gv')->nullable();            
            $table->string('pv_path')->nullable();
            $table->unsignedInteger('statut')->nullable();

            $table->unsignedInteger('fonctionnaire_id')->nullable();
            $table->foreign('fonctionnaire_id')->references('id')->on('fonctionnaires');

            $table->unsignedInteger('division_id')->nullable();
            $table->foreign('division_id')->references('id')->on('divisions');

            $table->unsignedInteger('deplacement_id')->nullable();
            $table->foreign('deplacement_id')->references('id')->on('deplacements');

            $table->unsignedInteger('nature_id')->nullable();
            $table->foreign('nature_id')->references('id')->on('natures');

            $table->unsignedInteger('type_vehicule_id')->nullable();
            $table->foreign('type_vehicule_id')->references('id')->on('type_vehicules');

            $table->unsignedInteger('vehicule_id')->nullable();
            $table->foreign('vehicule_id')->references('id')->on('vehicules');

            $table->unsignedInteger('chauffeur_id')->nullable();
            $table->foreign('chauffeur_id')->references('id')->on('chauffeurs');

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
        Schema::dropIfExists('missions');
    }
}
