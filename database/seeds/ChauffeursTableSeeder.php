<?php

use Illuminate\Database\Seeder;

class ChauffeursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('chauffeurs')->insert([
            ['cin' => 'SD45221','nom' => 'Haddad','prenom'=>'Ismail','phone' => '0655228877'],
            ['cin' => 'GH45754','nom' => 'Motarajji','prenom'=>'Zouhair','phone' => '0655228877'],
            ['cin' => 'HY44512','nom' => 'Ounajem','prenom'=>'Mohamed','phone' => '0655228877'],
        ]);
    }
}
