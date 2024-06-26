<?php

namespace App\Http\Controllers;

use App\Http\Requests\SongStoreRequest;
use App\Http\Requests\SongUpdateRequest;
use App\Models\Song;
use Exception;
use Illuminate\Support\Facades\DB;

class SongController extends Controller
{
    public function index()
    {
        DB::beginTransaction();

        try {
            $song = Song::searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Song list is successfully retrived', $song);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store(SongStoreRequest $request)
    {
        $payload = collect($request->validated());

        try {
            $filePath = $payload['file_path']->store('audio', 'public');
            $fileName = explode('/', $filePath)[1];
            $payload['file_path'] = $fileName;

            $song = Song::create($payload->toArray());
            DB::commit();

            return $this->success('Song is created successfully', $song);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $song = Song::findOrFail($id);
            DB::commit();

            return $this->success('Song detail is successfully retrived', $song);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(SongUpdateRequest $request, $id)
    {

        $payload = collect($request->validated());
        DB::beginTransaction();
        try {

            $song = Song::findOrFail($id);

            if (isset($payload['file_path']) && is_file($payload['file_path'])) {
                $filePath = $payload['file_path']->store('audio', 'public');
                $fileName = explode('/', $filePath)[1];
                $payload['file_path'] = $fileName;
            }

            $song->update($payload->toArray());

            DB::commit();

            return $this->success('Song is updated successfully', $song);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $song = Song::findOrFail($id);
            $song->delete();
            DB::commit();

            return $this->success('Genres is deleted successfully', $song);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
