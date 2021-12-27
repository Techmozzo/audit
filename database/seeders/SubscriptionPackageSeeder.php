<?php

namespace Database\Seeders;

use App\Models\SubscriptionPackage;
use Illuminate\Database\Seeder;

class SubscriptionPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = [
            ['name' => 'Gold', 'description' => 'Golden package', 'monthly_price' => 9.99, 'annual_price' => 99.99, 'feature' => json_encode(['test', 'test 2'])],
            ['name' => 'Silver', 'description' => 'Silver package', 'monthly_price' => 4.99, 'annual_price' => 48.99, 'feature' => json_encode(['test', 'test 3'])],
        ];

        foreach($packages as $package){
            SubscriptionPackage::create($package);
        }
    }
}
