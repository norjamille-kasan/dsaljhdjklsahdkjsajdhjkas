<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'Admin']);
        $agent = Role::create(['name' => 'Agent']);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole($admin);

        $test_user = User::create([
            'name' => 'Test-Agent',
            'email' => 'agent@gmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole($agent);
    }
}
