<?php

namespace Database\Seeders;

use App\Models\Assertion;
use Illuminate\Database\Seeder;

class AssertionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assertions = [
            ['name' => 'completeness','description' => 'Assertion'],
            ['name' => 'existence','description' => 'Aseertion'],
            ['name' => 'accuracy','description' => 'Aseertion'],
            ['name' => 'valuation','description' => 'Assertion'],
            ['name' => 'obligation_right','description' => 'Aseertion'],
            ['name' => 'disclosure_presentation','description' => 'Aseertion'],
        ];

        foreach($assertions as $assertion){
            Assertion::updateOrCreate(['name' => $assertion['name']], ['description' => $assertion['description']]);
        }
    }
}
