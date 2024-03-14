<?php

namespace App\Http\Controllers;

use App\Models\GenreInSinger;
use App\Http\Requests\GenreInSingerStoreRequest;
use App\Http\Requests\GenreInSingerUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenreInSingerController extends Controller
{
    public function index ()
    {
        DB::beginTransaction();

        try {
            $genreInSinger = GenreInSinger::with(['genres', 'singer'])
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Genre in singer list is successfully retrived', $genreInSinger);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store (GenreInSingerStoreRequest $request)
    {
        $payload = collect($request->validated());

        try {

            $genreInSinger = GenreInSinger::create($payload->toArray());
            DB::commit();

            return $this->success('Genre in singer is created successfully', $genreInSinger);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $genreInSinger = GenreInSinger::with(['genres', 'singer'])->findOrFail($id);
            DB::commit();

            return $this->success('Genre in singer detail is successfully retrived', $genreInSinger);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(GenreInSingerUpdateRequest $request, $id)
    {

        $payload = collect($request->validated());
        DB::beginTransaction();
        try {

            $genreInSinger = GenreInSinger::findOrFail($id);

            $genreInSinger->update($payload->toArray());

            DB::commit();

            return $this->success('Genre in singer is updated successfully', $genreInSinger);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }
}
