<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Enums\PaymentStatus;

class PaymentStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['id' => PaymentStatusEnum::PENDING->value, 'name' => PaymentStatusEnum::PENDING->getLabel()],
            ['id' => PaymentStatusEnum::COMPLETED->value, 'name' => PaymentStatusEnum::COMPLETED->getLabel()],
            ['id' => PaymentStatusEnum::FAILED->value, 'name' => PaymentStatusEnum::FAILED->getLabel()],
        ];
    }
}
