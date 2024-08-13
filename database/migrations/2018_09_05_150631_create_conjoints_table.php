<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConjointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conjoints', function (Blueprint $table) {
           $table->increments('id');
           $table->string('cin')->nullable();
           $table->string('nom')->nullable();
           $table->string('prenom')->nullable();

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
        Schema::dropIfExists('conjoints');
    }
}
