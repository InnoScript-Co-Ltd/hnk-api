<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoInSingerStoreRequest;
use App\Http\Requests\VideoInSingerUpdateRequest;
use App\Models\VideoInSinger;
use Illuminate\Support\Facades\DB;

class VideoInSingerController extends Controller
{
    protected $active;

    public function __construct()
    {
        $this->active = Auth('api')->user() ? [] : ['status' => 'ACTIVE'];
    }

    public function index()
    {
        DB::beginTransaction();

        try {
            $singer = VideoInSinger::where($this->active)
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Singer list is successfully retrived', $singer);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function showList($id)
    {
        DB::beginTransaction();

        try {
            $videoInSinger = VideoInSinger::where([
                'status' => 'ACTIVE',
                'singer_id' => $id,
            ])->get();

            DB::commit();

            return $this->success('Video in singer list is successfully retrived', $videoInSinger);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function store(VideoInSingerStoreRequest $request)
    {
        $payload = collect($request->validated());

        try {

            $videoPath = $payload['video'];
            $originName = $videoPath->getClientOriginalName();
            $extension = $videoPath->getClientOriginalExtension();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $fileName = $fileName.'_'.uniqid().'.'.$extension;
            $videoPath->move(public_path('video'), $fileName);
            $payload['video'] = $fileName;

            $videoInSinger = VideoInSinger::create($payload->toArray());
            DB::commit();

            return $this->success('Video in singer is created successfully', $videoInSinger);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $videoInSinger = VideoInSinger::with($this->active)->findOrFail($id);
            DB::commit();

            return $this->success('Video in singer detail is successfully retrived', $videoInSinger);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(VideoInSingerUpdateRequest $request, $id)
    {

        $payload = collect($request->validated());
        DB::beginTransaction();
        try {

            $videoInSinger = VideoInSinger::findOrFail($id);

            if (isset($payload['video'])) {
                $videoPath = $payload['video'];
                $originName = $videoPath->getClientOriginalName();
                $extension = $videoPath->getClientOriginalExtension();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $fileName = $fileName.'_'.uniqid().'.'.$extension;
                $videoPath->move(public_path('video'), $fileName);
                $payload['video'] = $fileName;
            }

            $videoInSinger->update($payload->toArray());
            DB::commit();

            return $this->success('video in singer is updated successfully', $videoInSinger);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $video = VideoInSinger::findOrFail($id);
            $video->delete();
            DB::commit();

            return $this->success('video in singer is deleted successfully', $video);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
