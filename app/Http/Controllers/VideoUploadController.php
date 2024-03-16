<?php

namespace App\Http\Controllers;

use App\Models\VideoUpload;
use App\Http\Requests\StoreVideoUploadRequest;
use App\Http\Requests\UpdateVideoUploadRequest;
use App\Http\Requests\VideoUploadStoreRequest;
use App\Http\Requests\VideoUploadUpdateRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VideoUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        DB::beginTransaction();
        try {
            $videoUploads = VideoUpload::searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Video upload list is successfully retrived', $videoUploads);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VideoUploadStoreRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();
        try {
            if ($request->hasFile('video_path')) {
                $videoPaths = [];
                foreach ($payload['video_path'] as $videoPath) {
                    $originName = $videoPath->getClientOriginalName();
                    $extension = $videoPath->getClientOriginalExtension();
                    $fileName = pathinfo($originName, PATHINFO_FILENAME);
                    $fileName = $fileName . '_' . uniqid() . '.' . $extension;
                    $videoPath->move(public_path('video_upload'), $fileName);

                    $videoPaths[] = 'video_upload/' . $fileName;
                }

                $payload['video_path'] = $videoPaths;
            }


            $videoUpload = VideoUpload::create($payload->toArray());
            DB::commit();

            return $this->success('Video upload is created successfully', $videoUpload);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        DB::beginTransaction();
        try {
            $videoUpload = VideoUpload::findOrFail($id);
            DB::commit();

            return $this->success('Video upload detail is successfully retrived', $videoUpload);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VideoUploadUpdateRequest $request, $id)
    {
        $payload = collect($request->validated());
        DB::beginTransaction();
        try {
            $videoUpload = VideoUpload::findOrFail($id);

            if ($request->hasFile('video_path')) {

                // Delete associated videos
                foreach ($videoUpload->video_path as $videoPath) {
                    File::delete($videoPath);
                }

                // store new videos
                $videoPaths = [];
                foreach ($payload['video_path'] as $videoPath) {
                    $originName = $videoPath->getClientOriginalName();
                    $extension = $videoPath->getClientOriginalExtension();
                    $fileName = pathinfo($originName, PATHINFO_FILENAME);
                    $fileName = $fileName . '_' . uniqid() . '.' . $extension;
                    $videoPath->move(public_path('video_upload'), $fileName);

                    $videoPaths[] = 'video_upload/' . $fileName;
                }

                $payload['video_path'] = $videoPaths;
            }

            $videoUpload->update($payload->toArray());

            DB::commit();

            return $this->success('Video upload is updated successfully', $videoUpload);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $videoUpload = VideoUpload::findOrFail($id);

            // Delete associated videos
            foreach ($videoUpload->video_path as $videoPath) {
                File::delete($videoPath);
            }

            $videoUpload->delete($id);
            DB::commit();

            return $this->success('Video upload is deleted successfully', $videoUpload);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
