<?php

use Illuminate\Database\Seeder;

class NaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('natures')->insert([
            ['libelle' => 'Coordination Equipe d\'animation', 'division_id' => '1'],
            ['libelle' => 'Reunion Avec Comité CLDH', 'division_id' => '1'],
            ['libelle' => 'Formation Continue', 'division_id' => '2'],
            ['libelle' => 'Management d\'équipe', 'division_id' => '2'],
        ]);
    }
}
