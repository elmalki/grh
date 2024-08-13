<?php

use Illuminate\Database\Seeder;

class VehiculesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('vehicules')->insert([
            ['marque' => 'Renault', 'numero' => '123456', 'type_vehicule_id' => '1'],
            ['marque' => 'Toyota', 'numero' => '558899', 'type_vehicule_id' => '1'],
            ['marque' => 'Honda', 'numero' => '105032', 'type_vehicule_id' => '1'],
        ]);
    }
}
