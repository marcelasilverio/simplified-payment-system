<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create([
            'user_type_id' => 1,
        ]);

        User::factory(10)->create([
            'user_type_id' => 2,
        ]);
    }
}
