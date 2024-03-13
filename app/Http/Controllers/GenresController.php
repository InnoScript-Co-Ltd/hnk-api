<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenresStoreRequest;
use App\Http\Requests\GenresUpdateRequest;
use App\Models\Genres;
use Illuminate\Support\Facades\DB;

class GenresController extends Controller
{
    public function index()
    {
        DB::beginTransaction();

        try {
            $genres = Genres::searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Genres list is successfully retrived', $genres);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store(GenresStoreRequest $request)
    {
        $payload = collect($request->validated());

        try {

            $genres = Genres::create($payload->toArray());
            DB::commit();

            return $this->success('Genres is created successfully', $genres);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $genres = Genres::findOrFail($id);
            DB::commit();

            return $this->success('Genres detail is successfully retrived', $genres);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(GenresUpdateRequest $request, $id)
    {

        $payload = collect($request->validated());
        DB::beginTransaction();
        try {

            $genres = Genres::findOrFail($id);

            $genres->update($payload->toArray());

            DB::commit();

            return $this->success('Genres is updated successfully', $genres);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $genres = Genres::findOrFail($id);
            $genres->delete($id);
            DB::commit();

            return $this->success('Genres is deleted successfully', $genres);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
