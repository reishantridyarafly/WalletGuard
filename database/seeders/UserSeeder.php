<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'phone_number' => '62895617545306',
                'password' => bcrypt('123456'),
                'type' => 0,
            ],

            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'User',
                'email' => 'user@gmail.com',
                'phone_number' => '62895617545309',
                'password' => bcrypt('123456'),
                'type' => 1,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
