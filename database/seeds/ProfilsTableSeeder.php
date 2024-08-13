<?php

use Illuminate\Database\Seeder;

class ProfilsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('profils')->insert([
            ['libelle' => 'Membre'],
            ['libelle' => 'Chef Disivion'],
            ['libelle' => 'SG'],
            ['libelle' => 'GV'],
            ['libelle' => 'RH'],
            ['libelle' => 'Chef Parc'],
        ]);
    }
}
