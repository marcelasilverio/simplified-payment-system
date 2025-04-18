<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\UserTypeModel;
use App\Enums\UserTypeEnum;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserTypeModel::upsert([
            ['id' => UserTypeEnum::MERCHANT, 'name' => UserTypeEnum::MERCHANT->getLabel(), 'is_allowed_to_transfer' => 0],
            ['id' => UserTypeEnum::COMMON, 'name' => UserTypeEnum::COMMON->getLabel(), 'is_allowed_to_transfer' => 1],
        ], ['id']);
    }
}
