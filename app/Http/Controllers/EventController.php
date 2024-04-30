<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Models\Event;
use Exception;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {

        DB::beginTransaction();

        try {

            $event = Event::with(['coverPhoto'])
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Event list is successfully retrived', $event);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store(EventStoreRequest $request)
    {
        $payload = collect($request->toArray());
        DB::beginTransaction();
        try {

            $event = Event::create($payload->toArray());

            if (isset($payload['cover_photo'])) {
                $imagePath = $payload['cover_photo']->store('images', 'public');
                $profileImage = explode('/', $imagePath)[1];
                $event->coverPhoto()->create(['image' => $profileImage]);
                $event['cover_photo'] = $profileImage;
            }

            DB::commit();

            return $this->success('Event is created successfully', $event);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function show($id)
    {
        DB::beginTransaction();

        try {

            $event = Event::with(['coverPhoto'])->findOrFail($id);
            DB::commit();

            return $this->success('Event detail is successfully retrived', $event);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(EventUpdateRequest $request, $id)
    {
        $payload = collect($request->toArray());
        DB::beginTransaction();

        try {

            $event = Event::findOrFail($id);

            if (isset($payload['cover_photo'])) {
                $imagePath = $payload['cover_photo']->store('images', 'public');
                $eventImage = explode('/', $imagePath)[1];
                $event->coverPhoto()->updateOrCreate(['imageable_id' => $event->id], [
                    'image' => $eventImage,
                    'imageable_id' => $event->id,
                ]);
                $event['cover_photo'] = $eventImage;
            }

            $event->update($payload->toArray());
            DB::commit();

            return $this->success('Event is updated successfully', $event);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $event = Event::findOrFail($id);
            $event->delete();
            DB::commit();

            return $this->success('Event is deleted successfully', $event);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
