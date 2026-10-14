<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        Coupon::updateOrCreate(['code' => 'WELCOME10'], ['type' => 'percent', 'value' => 10, 'is_active' => true, 'usage_limit' => 100]);
    }
}
