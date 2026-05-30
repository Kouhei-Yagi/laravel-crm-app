<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => '佐藤 太郎',
                'email' => 'taro.sato@example.com',
            ],
            [
                'name' => '鈴木 花子',
                'email' => 'hanako.suzuki@example.com',
            ],
            [
                'name' => '田中 一郎',
                'email' => 'ichiro.tanaka@example.com',
            ],
            [
                'name' => '山本 美咲',
                'email' => 'misaki.yamamoto@example.com',
            ],
            [
                'name' => '中村 健太',
                'email' => 'kenta.nakamura@example.com',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        }
    }
}
