<?php

namespace App\Http\Controllers;

use App\Http\Requests\MusicStoreRequest;
use App\Http\Requests\MusicUpdateRequest;
use App\Models\Music;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MusicController extends Controller
{
    public function index()
    {
        DB::beginTransaction();

        try {
            $music = Music::with(['user'])
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Music list is successfully retrived', $music);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store(MusicStoreRequest $request)
    {
        $payload = collect($request->toArray());

        DB::beginTransaction();

        try {

            $userId = $request->input('user_id');
            $audios = $request->file('audios');
            $music = new Music();

            // Store and process each audio file
            foreach ($audios as $audio) {
                $originalName = $audio->getClientOriginalName();

                $fileName = uniqid().'.'.$audio->getClientOriginalExtension();

                // Save the audio file to the storage directory
                $path = $audio->storeAs('public/audio', $fileName);

                // Create a new Music model instance and associate it with the user
                $music->user_id = $userId;
                $audiosArray = is_array($music->audios) ? $music->audios : [];
                $audiosArray[] = $path;
                $music->audios = $audiosArray;
            }

            $music->save();
            DB::commit();

            return $this->success('Audio is uploaded successfully', $music);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $music = Music::with(['user'])->findOrFail($id);
            DB::commit();

            return $this->success('Music detail is successfully retrived', $music);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(MusicUpdateRequest $request, $id)
    {
        $payload = collect($request->toArray());
        DB::beginTransaction();

        try {

            $userId = $request->input('user_id');
            $audioPayload = $request->file('audios');
            $music = Music::findOrFail($id);

            // Delete existing audio files
            foreach ($music->audios as $audio) {
                // Check if the audio file belongs to the current user
                if (Str::startsWith($audio, 'user_'.$userId)) {
                    Storage::delete($audio);
                }
            }

            $newAudios = [];
            // Process each uploaded audio file
            foreach ($audioPayload as $audio) {
                $originalName = $audio->getClientOriginalName();
                $fileName = uniqid().'.'.$audio->getClientOriginalExtension();

                // Save the audio file to the storage directory
                $path = $audio->storeAs('public/audio', $fileName);
                $newAudios[] = $path;
            }

            // Update the audios array with the new file paths
            $music->audios = $newAudios;
            $music->update($request->except('audios'));

            // Retrieve the updated music record to include the updated audios
            $updatedMusic = Music::findOrFail($id);

            DB::commit();

            return $this->success('Lyric is updated successfully', $updatedMusic);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $music = Music::findOrFail($id);
            $music->delete($id);
            DB::commit();

            return $this->success('Music is deleted successfully', $music);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
