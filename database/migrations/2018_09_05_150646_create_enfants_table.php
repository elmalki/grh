<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnfantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enfants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->date('dateNaissance')->nullable();
            $table->string('lieuNaissance')->nullable();
            $table->unsignedInteger('fonctionnaire_id')->nullable();
            $table->unsignedInteger('conjoint_id')->nullable();
            
            $table->foreign('fonctionnaire_id')->references('id')->on('fonctionnaires');
            $table->foreign('conjoint_id')->references('id')->on('conjoints');
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
        Schema::dropIfExists('enfants');
    }
}
