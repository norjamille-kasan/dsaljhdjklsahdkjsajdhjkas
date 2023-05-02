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
        $company = Company::create([
            'name' => 'Payreto',
        ]);

        $segmentsWithTask = [
            'Payreto - Technical Support' => [
                'Break',
                'Internal Training',
                'External Training',
                'Internal Meeting',
                'Client Meeting',
                'Admin & Other Tasks',
            ],
            'Payreto - Onboarding' => [
                'Break',
                'Internal Training',
                'External Training',
                'Internal Meeting',
                'Client Meeting',
                'Admin & Other Tasks',
            ],
            ' Payreto - Chargeback' => [
                'Break',
                'Internal Training',
                'External Training',
                'Internal Meeting',
                'Client Meeting',
                'Admin & Other Tasks',
            ],
        ];

        foreach ($segmentsWithTask as $segment => $tasks) {
            $segment = $company->segments()->create([
                'description' => $segment,
            ]);

            foreach ($tasks as $task) {
                $segment->tasks()->create([
                    'description' => $task,
                ]);
            }
        }
    }
}
