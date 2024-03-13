<?php

namespace App\Http\Controllers;

use App\Http\Requests\LyricStoreRequest;
use App\Http\Requests\LyricUpdateRequest;
use App\Models\Lyric;
use App\Http\Requests\StoreLyricRequest;
use App\Http\Requests\UpdateLyricRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class LyricController extends Controller
{
    public function index()
    {
        DB::beginTransaction();

        try {
            $lyrics = Lyric::searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Lyric list is successfully retrived', $lyrics);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store(LyricStoreRequest $request)
    {
        $payload = collect($request->validated());

        try {

            $lyric = Lyric::create($payload->toArray());
            DB::commit();

            return $this->success('Lyric is created successfully', $lyric);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $lyric = Lyric::findOrFail($id);
            DB::commit();

            return $this->success('Lyric detail is successfully retrived', $lyric);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(LyricUpdateRequest $request, $id)
    {

        $payload = collect($request->validated());
        DB::beginTransaction();
        try {

            $lyric = Lyric::findOrFail($id);

            $lyric->update($payload->toArray());

            DB::commit();

            return $this->success('Lyric is updated successfully', $lyric);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $lyric = Lyric::findOrFail($id);
            $lyric->delete($id);
            DB::commit();

            return $this->success('Lyric is deleted successfully', $lyric);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
