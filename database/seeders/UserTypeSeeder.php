<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\UserType;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserType::upsert([
            ['id' => UserType::MERCHANT, 'name' => 'merchant', 'is_allowed_to_transfer' => 0],
            ['id' => UserType::COMMON, 'name' => 'common', 'is_allowed_to_transfer' => 1],
        ], ['id']);
    }
}
