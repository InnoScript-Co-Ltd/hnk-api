<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function user()
    {

        DB::beginTransaction();
        try {

            $user = User::all()->count();
            $format = [
                'user' => $user,
            ];
            DB::commit();

            return $this->success('User count is successfully retrived', $format);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function userVotecount()
    {
        DB::beginTransaction();

        try {
            $genres = Genres::pluck('name')->toArray();
            $votes = User::all()->groupBy('vote_genre')->toArray();
            $voteResult = [];

            foreach ($genres as $genre) {
                if (isset($votes[$genre])) {
                    array_push($voteResult, [
                        'genre' => $genre,
                        'count' => count($votes[$genre]),
                    ]);
                }
            }

            DB::commit();

            return $this->success('User vote count is successfully retrived', $voteResult);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
