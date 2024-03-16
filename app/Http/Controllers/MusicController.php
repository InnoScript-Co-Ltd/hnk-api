<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Http\Requests\MusicStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

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

        try{

            DB::beginTransaction();

            $userId = $request->input('user_id');
            $audios = $request->file('audios');
            $music = new Music();
    
            // Store and process each audio file
            foreach ($audios as $audio) {
                $originalName = $audio->getClientOriginalName();
    
                $fileName = uniqid() . '.' . $audio->getClientOriginalExtension();
                
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

}
