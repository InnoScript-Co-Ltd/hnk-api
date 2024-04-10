<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutletStoreRequest;
use App\Http\Requests\OutletUpdateRequest;
use App\Models\Outlet;
use Exception;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
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
            $outlets = Outlet::where($this->active)
                ->with(['image'])
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->distanceQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('outlet list is successfully retrived', $outlets);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store(OutletStoreRequest $request)
    {
        $payload = collect($request->validated());

        try {

            $outlet = Outlet::create($payload->toArray());
            if (isset($payload['image'])) {
                $imagePath = $payload['image']->store('images', 'public');
                $profileImage = explode('/', $imagePath)[1];
                $outlet->image()->create(['image' => $profileImage]);
            }
            DB::commit();

            return $this->success('Outlet is created successfully', $outlet);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $outlet = Outlet::with(['image'])->where($this->active)->findOrFail($id);
            DB::commit();

            return $this->success('Outlet detail is successfully retrived', $outlet);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(OutletUpdateRequest $request, $id)
    {

        $payload = collect($request->validated());
        DB::beginTransaction();
        try {

            $outlet = Outlet::with(['image'])->findOrFail($id);

            $outlet->update($payload->toArray());

            if (isset($payload['image'])) {
                $imagePath = $payload['image']->store('images', 'public');
                $profileImage = explode('/', $imagePath)[1];
                $outlet->image()->updateOrCreate(['imageable_id' => $outlet->id], [
                    'image' => $profileImage,
                    'imageable_id' => $outlet->id,
                ]);
                $outlet['image'] = [
                    'image' => $profileImage,
                ];
            }

            DB::commit();

            return $this->success('Outlet is updated successfully', $outlet);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $outlet = Outlet::findOrFail($id);
            $outlet->delete();
            DB::commit();

            return $this->success('Outlet is deleted successfully', $outlet);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
