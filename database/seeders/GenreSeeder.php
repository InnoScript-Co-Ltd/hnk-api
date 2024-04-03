<?php

namespace Database\Seeders;

use App\Models\Genres;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            [
                'id' => Str::uuid(),
                'name' => 'Rap',
                'color' => '#00f2ec',
                'status' => 'ACTIVE',
                'rate' => 0,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Pop',
                'color' => '#ff00f5',
                'status' => 'ACTIVE',
                'rate' => 0,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'R&B',
                'color' => '#0047ff',
                'status' => 'ACTIVE',
                'rate' => 0,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Rock',
                'color' => '#24ff00',
                'status' => 'ACTIVE',
                'rate' => 0,
            ],
        ];

        try {
            DB::beginTransaction();
            $genres = Genres::insert($genres);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
