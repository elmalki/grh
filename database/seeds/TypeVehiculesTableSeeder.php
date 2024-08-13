<?php

use Illuminate\Database\Seeder;

class TypeVehiculesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('type_vehicules')->insert([
            ['libelle' => 'Service Province'],
            ['libelle' => 'Personnel'],
            ['libelle' => 'Commun']
        ]);
    }
}
