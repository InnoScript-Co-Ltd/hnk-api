<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaylistStoreRequest;
use App\Http\Requests\PlaylistUpdateRequest;
use App\Models\Playlist;
use Exception;
use Illuminate\Support\Facades\DB;

class PlaylistController extends Controller
{
    public function index()
    {
        DB::beginTransaction();

        try {
            $playlists = Playlist::searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Playlist list is successfully retrived', $playlists);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store(PlaylistStoreRequest $request)
    {
        $payload = collect($request->validated());

        try {

            $playlist = Playlist::create($payload->toArray());
            DB::commit();

            return $this->success('Playlist is created successfully', $playlist);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $playlist = Playlist::findOrFail($id);
            DB::commit();

            return $this->success('Playlist detail is successfully retrived', $playlist);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(PlaylistUpdateRequest $request, $id)
    {

        $payload = collect($request->validated());
        DB::beginTransaction();
        try {

            $playlist = Playlist::findOrFail($id);

            $playlist->update($payload->toArray());

            DB::commit();

            return $this->success('Playlist is updated successfully', $playlist);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $playlist = Playlist::findOrFail($id);
            $playlist->delete($id);
            DB::commit();

            return $this->success('Playlist is deleted successfully', $playlist);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
