<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Gender;
use App\Models\Type_bloods;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BloodTableSeeder::class
        ]);
        $this->call([
            NationalitieSeeder::class
        ]);
        $this->call([
            religionTableSeeder::class
        ]);
        $this->call([
            SpecializationsTableSeeder::class
        ]);
        $this->call([
            GenderTableSeeder::class
        ]);
        $this->call([
            UsersTableSeeder::class
        ]);
    }
}
