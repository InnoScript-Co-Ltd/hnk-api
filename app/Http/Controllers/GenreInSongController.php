<?php

namespace App\Http\Controllers;

use App\Models\GenreInSong;
use App\Http\Requests\GenreInSongStoreRequest;
use App\Http\Requests\GenreInSongUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenreInSongController extends Controller
{
    public function index ()
    {
        DB::beginTransaction();

        try {
            $genreInSong = GenreInSong::with(['genres', 'song'])
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Genre in song list is successfully retrived', $genreInSong);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store (GenreInSongStoreRequest $request)
    {
        $payload = collect($request->validated());

        try {

            $genreInSong = GenreInSong::create($payload->toArray());
            DB::commit();

            return $this->success('Genre in song is created successfully', $genreInSong);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $genreInSong = GenreInSong::with(['genres', 'song'])->findOrFail($id);
            DB::commit();

            return $this->success('Genre in song detail is successfully retrived', $genreInSong);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(GenreInSongUpdateRequest $request, $id)
    {

        $payload = collect($request->validated());
        DB::beginTransaction();
        try {

            $genreInSong = GenreInSong::findOrFail($id);

            $genreInSong->update($payload->toArray());

            DB::commit();

            return $this->success('Genre in song is updated successfully', $genreInSong);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }
}
