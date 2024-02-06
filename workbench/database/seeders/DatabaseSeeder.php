<?php

namespace Workbench\Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Outl1ne\NovaOpenAI\Database\Factories\UserFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserFactory::new()->create([
            'name' => 'Admin',
            'email' => 'admin@localhost',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            OpenaiRequestSeeder::class,
        ]);
    }
}
