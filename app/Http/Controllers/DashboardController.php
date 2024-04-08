<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class DashboardController extends Controller
{
    public function user() {

        DB::beginTransaction();
        try {
                
            $user = User::all()->count();
            $format = [
                "user" => $user
            ];
            DB::commit();

            return $this->success('User count is successfully retrived', $format);

        } catch (Exception $e) {
            throw $e;
            DB::rollback();
        }

    }

    public function userVotecount () 
    {
        DB::beginTransaction();
        try {

            $genres = Genres::pluck('name')->toArray();

            $votes = User::all()->groupBy('vote_genre')->map(function ($users, $genre) {
                return count($users);
            })->toArray();

            $votes[''] = $votes[''] ?? 0; // If there are no users with empty string vote, set count to 0
            
            foreach ($genres as $genre) {
                $votes[$genre] = $votes[$genre] ?? 0; // If there are no users for this genre, set count to 0
            }

            // dd($votes);
            $object = [
                "none" => $votes[''],
                "Rock" => $votes["Rock"],
                "R&B" => $votes['R&B'],
                "Pop" => $votes['Pop'],
                "Rap" => $votes['Rap']
            ];

            DB::commit();

            return $this->success('User vote count is successfully retrived', $object);


        } catch (Exception $e) {
            throw $e;
            DB::rollback();
        }
    }
}
