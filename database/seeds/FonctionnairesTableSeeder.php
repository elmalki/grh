<?php

use Illuminate\Database\Seeder;

class FonctionnairesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('fonctionnaires')->insert([
            [
            'cin' => 'membre_das1',
            'nom' => 'membre_das1',
            'prenom' => 'membre_das1',
            'grade_id' => '1',
            'division_id' => '1',
            'profil_id' => '1',
            'password' => bcrypt('membre_das1')
            ],
            [
                'cin' => 'membre_das2',
                'nom' => 'membre_das2',
                'prenom' => 'membre_das2',
                'grade_id' => '1',
                'division_id' => '1',
                'profil_id' => '1',
                'password' => bcrypt('membre_das2')
            ],
            [
                'cin' => 'chef_das',
                'nom' => 'chef_das',
                'prenom' => 'chef_das',
                'grade_id' => '1',
                'division_id' => '1',
                'profil_id' => '2',
                'password' => bcrypt('chef_das')
            ],
            [
                'cin' => 'membre_drh1',
                'nom' => 'membre_drh1',
                'prenom' => 'membre_drh1',
                'grade_id' => '1',
                'division_id' => '2',
                'profil_id' => '1',
                'password' => bcrypt('membre_drh1')
                ],
                [
                    'cin' => 'membre_drh2',
                    'nom' => 'membre_drh2',
                    'prenom' => 'membre_drh2',
                    'grade_id' => '1',
                    'division_id' => '2',
                    'profil_id' => '1',
                    'password' => bcrypt('membre_drh2')
                ],
                [
                    'cin' => 'chef_drh',
                    'nom' => 'chef_drh',
                    'prenom' => 'chef_drh',
                    'grade_id' => '1',
                    'division_id' => '2',
                    'profil_id' => '2',
                    'password' => bcrypt('chef_drh')
                ],
                [
                    'cin' => 'sg',
                    'nom' => 'sg',
                    'prenom' => 'sg',
                    'grade_id' => '1',
                    'division_id' => '3',
                    'profil_id' => '3',
                    'password' => bcrypt('sg')
                ],
                [
                    'cin' => 'gv',
                    'nom' => 'gv',
                    'prenom' => 'gv',
                    'grade_id' => '1',
                    'division_id' => '3',
                    'profil_id' => '4',
                    'password' => bcrypt('gv')
                ],
                [
                    'cin' => 'rh',
                    'nom' => 'rh',
                    'prenom' => 'rh',
                    'grade_id' => '1',
                    'division_id' => '3',
                    'profil_id' => '5',
                    'password' => bcrypt('rh')
                ],
                [
                    'cin' => 'chef_parc',
                    'nom' => 'chef_parc',
                    'prenom' => 'chef_parc',
                    'grade_id' => '1',
                    'division_id' => '3',
                    'profil_id' => '6',
                    'password' => bcrypt('chef_parc')
                ],
        ]);
    }
}
