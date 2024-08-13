<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttestationFonctionnaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attestation_fonctionnaire', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fonctionnaire_id');
            $table->foreign('fonctionnaire_id')->references('id')->on('fonctionnaires');

            $table->unsignedInteger('attestation_id');
            $table->foreign('attestation_id')->references('id')->on('attestations');

            $table->string('statut');

            $table->unsignedInteger('nombre');
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
        Schema::dropIfExists('attestation_fonctionnaire');
    }
}
