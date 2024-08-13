<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call([
            TypeDeplacementsTableSeeder::class,
            DeplacementsTableSeeder::class,
            TypeVehiculesTableSeeder::class,
            VehiculesTableSeeder::class,
            GradesTableSeeder::class,
            DivisionsTableSeeder::class,
            NaturesTableSeeder::class,
            ProfilsTableSeeder::class,
            FonctionnairesTableSeeder::class,
            ChauffeursTableSeeder::class,
            StatutsTableSeeder::class,
        ]);
    }
}
