<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenresStoreRequest;
use App\Http\Requests\GenresUpdateRequest;
use App\Models\Genres;
use Exception;
use Illuminate\Support\Facades\DB;

class GenresController extends Controller
{
    private $active;

    public function __construct()
    {
        $this->active = Auth('api')->user() ? [] : ['status' => 'ACTIVE'];
    }

    public function index()
    {
        DB::beginTransaction();

        try {
            $genres = Genres::where($this->active)
                ->with(['icon'])
                ->searchQuery()
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

            $genre = Genres::create($payload->toArray());

            $imagePath = $payload['icon']->store('images', 'public');
            $iconImage = explode('/', $imagePath)[1];
            $genre->icon()->updateOrCreate(['image' => $iconImage]);
            $genre['icon'] = $iconImage;
            DB::commit();

            return $this->success('Genres is created successfully', $genre);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $genres = Genres::with(['icon'])->where($this->active)->findOrFail($id);
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

            $genre = Genres::findOrFail($id);

            $genre->update($payload->toArray());

            if ($payload['icon']) {
                $imagePath = $payload['icon']->store('images', 'public');
                $iconImage = explode('/', $imagePath)[1];
                $genre->icon()->updateOrCreate(['image' => $iconImage]);
                $genre['icon'] = $iconImage;
            }
            DB::commit();

            return $this->success('Genre is updated successfully', $genre);

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
            $genres->delete();
            DB::commit();

            return $this->success('Genres is deleted successfully', $genres);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
