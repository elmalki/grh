<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenParlersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('men_parlers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('mission_id')->nullable();
            $table->unsignedInteger('appelant_id')->nullable();
            $table->unsignedInteger('appele_id')->nullable();
            $table->text('description')->nullable();
            $table->foreign('appelant_id')->references('id')->on('fonctionnaires');
            $table->foreign('appele_id')->references('id')->on('fonctionnaires');
            $table->foreign('mission_id')->references('id')->on('missions');
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
        Schema::dropIfExists('men_parlers');
    }
}
