<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function createAccount(
        string $name,
        string $email,
        string $password,
        string $role = 'Agent' | 'Admin'
    ) {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $user->assignRole($role);

        return $user;
    }

    public function updateAccount(
        $user,
        string $name,
        string $email,
    ) {
        $user->update([
            'name' => $name,
            'email' => $email,
        ]);

        return $user;
    }

    public function deleteAccount($user)
    {
        $user->delete();
    }

    public function resetPassword($user)
    {
        $default = 'password12345';
        $user->update([
            'password' => bcrypt($default),
        ]);
    }
}
