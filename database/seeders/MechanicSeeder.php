<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mechanic;
use Database\Factories\MechanicFactory;

class MechanicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

            Mechanic::factory()->create([
            'name' => 'Aleksander Hallan',
            'phonenumber' => '91318674',
            'email' => 'aleksander.hallan@bilbutikk1.no',
            'title' => 'Personlig Service Tekniker',
            ], 
            );
            Mechanic::factory()->create([
            'name' => 'Trond Stømnes',
            'phonenumber' => '92103567',
            'email' => 'trond.stomnes@bilbutikk1.no',
            'title' => 'Intern PST',
            ], 
            );
    }
}
