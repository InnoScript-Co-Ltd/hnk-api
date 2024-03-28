<?php

namespace App\Http\Controllers;

use App\Http\Requests\SingerSongStoreRequest;
use App\Models\SingerSong;
use Illuminate\Support\Facades\DB;

class SingerSongController extends Controller
{
    public function index()
    {
        DB::beginTransaction();

        try {
            $singerSong = SingerSong::with(['song', 'singer'])
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Singer song list is successfully retrived', $singerSong);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store(SingerSongStoreRequest $request)
    {
        $payload = collect($request->validated());

        try {

            $singerSong = SingerSong::create($payload->toArray());
            DB::commit();

            return $this->success('Singer song is created successfully', $singerSong);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
