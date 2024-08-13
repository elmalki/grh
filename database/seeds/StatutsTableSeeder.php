<?php

use Illuminate\Database\Seeder;

class StatutsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('statuts')->insert([
            [ "libelle" => "En Attente"],
            [ "libelle" => "Départ Validé (CD)"],
            [ "libelle" => "Départ Validé (SG)"],
            [ "libelle" => "Mission Complet"],
            [ "libelle" => "Arrivé Validé (CD)"],
            [ "libelle" => "Arrivé Validé (SG)"],
        ]);
    }
}
