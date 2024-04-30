<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenresStoreRequest;
use App\Http\Requests\GenresUpdateRequest;
use App\Models\Genres;
use App\Models\User;
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

            $userVotes = User::pluck('vote_genre');

            $genres->map(function ($genre) use ($userVotes) {
                $totalVote = $userVotes->filter(function ($vote) use ($genre) {
                    if ($vote === $genre['name']) {
                        return $vote;
                    }
                });

                if ($genre['auto_rate'] === 'ACTIVE') {
                    $genre['show_rate'] = count($userVotes->toArray()) > 0 ? count($totalVote->toArray()) * 100 / count($userVotes->toArray()) : 0;
                } else {
                    $genre['show_rate'] = $genre['rate'] * 100 / 100;
                }

                return $genre;
            });
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

            if (isset($payload['icon'])) {
                $imagePath = $payload['icon']->store('images', 'public');
                $iconImage = explode('/', $imagePath)[1];
                $genre->icon()->updateOrCreate(['imageable_id' => $genre->id], [
                    'image' => $iconImage,
                    'imageable_id' => $genre->id,
                ]);
            }

            $genre->update($payload->toArray());
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
