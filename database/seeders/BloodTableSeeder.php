<?php

namespace Database\Seeders;

use App\Models\Type_bloods;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BloodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('type_bloods')->delete();
        $bgs = ['O-','O+','A-','A+','B-','B+','AB-','AB+'];
        foreach ($bgs as $bg){
            Type_bloods::create(['Name'=>$bg]);
        }
    }
}
