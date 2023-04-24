<?php

namespace Database\Seeders;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i=1; $i < 10; $i++) {
            $companyId = $i % 2 === 0 ? $i - 1 : null;

            Company::create(
                [
                    'parent_company_id' => $companyId,
                    'name' => $faker->company,
                    'created_at' => Carbon::now()->format('Y-m-d'),
                    'updated_at' => Carbon::now()->format('Y-m-d')
                ]
            );
        }
    }
}
