<?php

namespace App\Http\Controllers;

use App\Http\Requests\EpisodeStoreRequest;
use App\Http\Requests\EpisodeUpdateRequest;
use App\Models\Episode;
use Exception;
use Illuminate\Support\Facades\DB;

class EpisodeContrller extends Controller
{
    public function index()
    {
        DB::beginTransaction();

        try {
            $episodes = Episode::with(['singer'])
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Episode list is successfully retrived', $episodes);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function store(EpisodeStoreRequest $request)
    {
        $payload = collect($request->validated());

        try {

            $episode = Episode::create($payload->toArray());
            DB::commit();

            return $this->success('Episode is created successfully', $episode);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $episode = Episode::with(['singer'])->findOrFail($id);
            DB::commit();

            return $this->success('Episode detail is successfully retrived', $episode);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function findByUrl($url)
    {
        DB::beginTransaction();

        try {
            $episode = Episode::with(['singer'])->where(['url' => $url])->first();
            DB::commit();

            return $this->success('Episode search by url is successfully retrived', $episode);

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(EpisodeUpdateRequest $request, $id)
    {

        $payload = collect($request->validated());
        DB::beginTransaction();

        try {

            $episode = Episode::findOrFail($id);
            $episode->update($payload->toArray());
            DB::commit();

            return $this->success('Episode is updated successfully', $episode);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $episode = Episode::findOrFail($id);

            $episode->delete();

            DB::commit();

            return $this->success('Episode is deleted successfully', $episode);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
