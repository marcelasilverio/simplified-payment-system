<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserType::upsert([
            ['id' => 1, 'name' => 'merchant', 'is_allowed_to_transfer' => 0],
            ['id' => 2, 'name' => 'common', 'is_allowed_to_transfer' => 1],
        ], ['id']);
    }
}
