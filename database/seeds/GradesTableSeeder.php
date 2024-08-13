<?php

use Illuminate\Database\Seeder;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grades')->insert([
            ['libelle' => 'Administrateur'],
            ['libelle' => 'Ingénieur'],
            ['libelle' => 'DAT']
        ]);
    }
}
