<?php

namespace Database\Seeders;

use App\Enums\AdminStatusEnum;
use App\Helpers\Enum;
use App\Models\Admin;
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
        $adminStatus = (new Enum(AdminStatusEnum::class))->values();
        $status = $adminStatus[rand(0, count($adminStatus) - 1)];

        $superAdmin = [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '9421038123',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'status' => $adminStatus[1],
        ];

        try {
            Admin::create($superAdmin);
        } catch (Exception $e) {
            throw ($e);
        }
    }
}
