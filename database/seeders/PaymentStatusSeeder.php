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
            ['id' => PaymentStatusEnum::APPROVED->value, 'name' => PaymentStatusEnum::APPROVED->getLabel()],
            ['id' => PaymentStatusEnum::DENIED->value, 'name' => PaymentStatusEnum::DENIED->getLabel()],
        ];
    }
}
