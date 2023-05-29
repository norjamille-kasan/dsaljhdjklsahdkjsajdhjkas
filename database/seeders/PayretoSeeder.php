<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class PayretoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Company::create(['name' => 'Payreto']);
        $segment = $company->segments()->create(['description' => 'Payreto - Technical Support']);
        $segment->tasks()->create(['name' => 'Break']);
        $segment->tasks()->create(['name' => 'Internal Training']);
        $segment->tasks()->create(['name' => 'External Training']);
        $segment->tasks()->create(['name' => 'Internal Meeting']);
        $segment->tasks()->create(['name' => 'Client Meeting']);
        $segment->tasks()->create(['name' => 'Admin & Other Tasks']);

        $segment = $company->segments()->create(['description' => 'Payreto - Onboarding']);
        $segment->tasks()->create(['name' => 'Break']);
        $segment->tasks()->create(['name' => 'Internal Training']);
        $segment->tasks()->create(['name' => 'External Training']);
        $segment->tasks()->create(['name' => 'Internal Meeting']);
        $segment->tasks()->create(['name' => 'Client Meeting']);
        $segment->tasks()->create(['name' => 'Admin & Other Tasks']);

        $segment = $company->segments()->create(['description' => 'Payreto - Chargeback']);
        $segment->tasks()->create(['name' => 'Break']);
        $segment->tasks()->create(['name' => 'Internal Training']);
        $segment->tasks()->create(['name' => 'External Training']);
        $segment->tasks()->create(['name' => 'Internal Meeting']);
        $segment->tasks()->create(['name' => 'Client Meeting']);
        $segment->tasks()->create(['name' => 'Admin & Other Tasks']);
    }
}
