<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::role('Admin')->first();
       $permission = Permission::create(['name' => 'access to dashboard']);
       $user->givePermissionTo($permission);
        // Task
       $permission = Permission::create(['name' => 'create task']);
       $user->givePermissionTo($permission);

       $permission = Permission::create(['name' => 'edit task']);
       $user->givePermissionTo($permission);

       $permission = Permission::create(['name' => 'delete task']);
       $user->givePermissionTo($permission);
        // submissions
       $permission = Permission::create(['name' => 'view submissions']);
       $user->givePermissionTo($permission);
        // User
       $permission = Permission::create(['name' => 'create user']);
       $user->givePermissionTo($permission);

       $permission = Permission::create(['name' => 'edit user']);
       $user->givePermissionTo($permission);
       $permission = Permission::create(['name' => 'delete user']);
       $user->givePermissionTo($permission);
       $permission = Permission::create(['name' => 'manage permissions']);
       $user->givePermissionTo($permission);
        // reports
       $permission = Permission::create(['name' => 'view reports']);
       $user->givePermissionTo($permission);


       $user = User::create([
        'name' => 'Admin 2',
        'email' => 'admin2@gmail.com',
        'password' => bcrypt('12345678'),
       ]);
       $user->assignRole('Admin');
    }
}
