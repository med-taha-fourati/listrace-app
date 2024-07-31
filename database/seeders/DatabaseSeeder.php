<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Type;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Type::factory()->create([
            'type_name' => 'Hotel'
        ]);

        Type::factory()->create([
            'type_name' => 'Restaurant'
        ]);

        Type::factory()->create([
            'type_name' => 'Automotives'
        ]);

        Type::factory()->create([
            'type_name' => 'Healthcare'
        ]);

        Type::factory()->create([
            'type_name' => 'Destination'
        ]);
        
        User::factory(10)->create();


        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);
    }
}
