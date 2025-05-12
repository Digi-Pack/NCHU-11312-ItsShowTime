<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UsersInfo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $backendUsers = [
            [
                'name' => 'YZ',
                'email' => 'yunchun1124@gmail.com',
                'password' => '88888888',
                'role' => 1,
            ],
            [
                'name' => 'A',
                'email' => 'babyangelababy0405@gmail.com',
                'password' => '88888888',
                'role' => 1,
            ],
            [
                'name' => 'L',
                'email' => 'zc235475@gmail.com',
                'password' => '88888888',
                'role' => 1,
            ],
        ];

        foreach ($backendUsers as $user) {
            $newUser = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'role' => $user['role'],
            ]);

            UsersInfo::create([
                'user_id' => $newUser->id,
                'name' => $newUser->name,
                'email' => $newUser->email,
            ]);
        };
    }
}
