<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionStatutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_statut', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('mission_id')->nullable();
            $table->foreign('mission_id')->references('id')->on('missions');

            $table->unsignedInteger('statut_id')->nullable();
            $table->foreign('statut_id')->references('id')->on('statuts');
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
        Schema::dropIfExists('mission_statut');
    }
}
