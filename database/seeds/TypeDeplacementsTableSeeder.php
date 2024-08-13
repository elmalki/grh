<?php

use Illuminate\Database\Seeder;

class TypeDeplacementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('type_deplacements')->insert([
            ['libelle' => 'Nationale'],
            ['libelle' => 'Régionale'],
            ['libelle' => 'Provinciale']
        ]);
    }
}
