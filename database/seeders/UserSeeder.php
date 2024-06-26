<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    protected static ?string $password;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $superAdmin = [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '9421038123',
            'dob' => '2002-2-2',
            'fav_music' => null,
            // 'gender' => 'male',
            // 'is_accept' => false,
        ];

        try {
            User::create($superAdmin);
        } catch (Exception $e) {
            throw ($e);
        }
    }
}
