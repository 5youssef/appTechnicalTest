<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Youssef Herrouch',
                'email'          => 'ucef@gmail.com',
                'password'       => Hash::make('password'),
                'remember_token' => null,
                'is_manager'     => 1,
            ],
        ];

        User::insert($users);
    }
}
