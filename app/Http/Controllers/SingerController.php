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
            $singer = Singer::searchQuery()
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

    public function store(SingerStoreRequest $request)
    {
        $payload = collect($request->validated());

        try {

            if (isset($payload['profile'])) {
                $profileImagePath = $payload['profile']->store('images', 'public');
                $profileImage = explode('/', $profileImagePath)[1];
                $payload['profile'] = $profileImage;
            }

            if (isset($payload['cover_photo'])) {
                $coverPhotoImagePath = $payload['cover_photo']->store('images', 'public');
                $coverPhotoImage = explode('/', $coverPhotoImagePath)[1];
                $payload['cover_photo'] = $coverPhotoImage;
            }

            if (isset($payload['slider_image'])) {
                $imagePath = $payload['slider_image']->store('images', 'public');
                $sliderImage = explode('/', $imagePath)[1];
                $payload['slider_image'] = $sliderImage;
            }

            $singer = Singer::create($payload->toArray());

            DB::commit();

            return $this->success('Singer is created successfully', $singer);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $singer = Singer::with(['videos'])->findOrFail($id);
            DB::commit();

            return $this->success('Singer detail is successfully retrived', $singer);

        } catch (\Exception $e) {
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
                $profileImagePath = $payload['profile']->store('images', 'public');
                $profileImage = explode('/', $profileImagePath)[1];
                $payload['profile'] = $profileImage;
            }

            if (isset($payload['cover_photo'])) {
                $coverPhotoImagePath = $payload['cover_photo']->store('images', 'public');
                $coverPhotoImage = explode('/', $coverPhotoImagePath)[1];
                $payload['cover_photo'] = $coverPhotoImage;
            }

            if (isset($payload['slider_image'])) {
                $sliderImagePath = $payload['slider_image']->store('images', 'public');
                $sliderImage = explode('/', $sliderImagePath)[1];
                $payload['slider_image'] = $sliderImage;
            }

            if (isset($payload['invite_video'])) {
                $inviteVideoPath = $payload['invite_video']->store('images', 'public');
                $inviteVideo = explode('/', $inviteVideoPath)[1];
                $payload['invite_video'] = $inviteVideo;
            }

            $singer->update($payload->toArray());

            DB::commit();

            return $this->success('Singer is updated successfully', $singer);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $singer = Singer::findOrFail($id);
            $singer->delete();
            DB::commit();

            return $this->success('Singer is deleted successfully', $singer);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
