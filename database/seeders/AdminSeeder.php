<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
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
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
        ];

        try {
            Admin::create($superAdmin);
        } catch (Exception $e) {
            throw ($e);
        }
    }
}
