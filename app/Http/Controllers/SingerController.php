<?php

namespace App\Http\Controllers;

use App\Http\Requests\SingerStoreRequest;
use App\Http\Requests\SingerUpdateRequest;
use App\Models\Singer;
use Illuminate\Support\Facades\DB;

class SingerController extends Controller
{
    public function index()
    {
        DB::beginTransaction();

        try {
            $singer = Singer::with(['image'])
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Singer list is successfully retrived', $singer);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store(SingerStoreRequest $request)
    {
        $payload = collect($request->validated());

        try {

            $singer = Singer::create($payload->toArray());
            DB::commit();

            return $this->success('Singer is created successfully', $singer);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $singer = Singer::with(['image'])->findOrFail($id);
            DB::commit();

            return $this->success('Singer detail is successfully retrived', $singer);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(SingerUpdateRequest $request, $id)
    {

        $payload = collect($request->validated());
        DB::beginTransaction();
        try {

            $singer = Singer::findOrFail($id);

            if (isset($payload['profile'])) {
                $imagePath = $payload['profile']->store('images', 'public');
                $profileImage = explode('/', $imagePath)[1];
                $singer->image()->updateOrCreate(['imageable_id' => $singer->id], [
                    'image' => $profileImage,
                    'imageable_id' => $singer->id,
                ]);
            }

            $singer->update($payload->toArray());

            DB::commit();

            return $this->success('Singer is updated successfully', $singer);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $singer = Singer::findOrFail($id);
            $singer->delete($id);
            DB::commit();

            return $this->success('Singer is deleted successfully', $singer);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
