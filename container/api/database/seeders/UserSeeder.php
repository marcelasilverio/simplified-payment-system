<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Enums\UserTypeEnum;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        UserModel::factory(10)->create([
            'user_type_id' => UserTypeEnum::MERCHANT,
            'initial_balance' => 1000,
        ]);

        UserModel::factory(10)->create([
            'user_type_id' => UserTypeEnum::COMMON,
            'initial_balance' => 1000,
        ]);
    }
}
