<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserStatusEnum;
use App\Helpers\Enum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    protected static ?string $password;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userStatus = (new Enum(UserStatusEnum::class))->values();
        $status = $userStatus[rand(0, count($userStatus) - 1)];

        $superAdmin = [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '9421038123',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'status' => $userStatus[0]
        ];

        try {
            User::create($superAdmin);
        } catch (Exception $e) {
            throw ($e);
        }
    }
}
