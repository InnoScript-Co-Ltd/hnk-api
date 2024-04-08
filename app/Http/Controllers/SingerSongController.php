<?php

namespace App\Http\Controllers;

use App\Http\Requests\SingerSongStoreRequest;
use App\Http\Requests\SingerSongUpdateRequest;
use App\Models\SingerSong;
use Exception;
use Illuminate\Support\Facades\DB;

class SingerSongController extends Controller
{
    private $active;

    public function __construct()
    {
        $this->active = Auth('api')->user() ? [] : ['status' => 'ACTIVE'];
    }

    public function singerInSong()
    {
        DB::beginTransaction();

        try {
            $singerSong = SingerSong::where(['status' => 'ACTIVE'])
                ->with([
                    'song',
                    'singer' => fn ($query) => $query->with(['profile']),
                ])
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

    public function index()
    {
        DB::beginTransaction();

        try {
            $singerSong = SingerSong::where($this->active)
                ->with(['song', 'singer' => fn ($query) => $query->with(['profile'])])
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

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $singerSong = SingerSong::with(['song', 'singer' => fn ($query) => $query->with(['profile'])])->where($this->active)->findOrFail($id);
            DB::commit();

            return $this->success('Singer song detail is successfully retrived', $singerSong);
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

    public function update(SingerSongUpdateRequest $request, $id)
    {

        $payload = collect($request->validated());
        DB::beginTransaction();

        try {

            $singerSong = SingerSong::findOrFail($id);
            $singerSong->update($payload->toArray());
            DB::commit();

            return $this->success('Singer song is updated successfully', $singerSong);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }
}
