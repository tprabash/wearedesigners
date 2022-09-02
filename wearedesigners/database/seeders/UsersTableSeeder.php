<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Tharindu',
                'email'          => 'admin@wearedesigners.net',
                'password'       => bcrypt('654321'),
                'remember_token' => null,
                'approved'       => 1,
            ],
        ];

        User::insert($users);
    }
}
