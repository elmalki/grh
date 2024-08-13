<?php

use Illuminate\Database\Seeder;

class DivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('divisions')->insert([
            ['libelle' => 'DAS'],
            ['libelle' => 'DRH'],
            ['libelle' => 'SG']
        ]);
    }
}
