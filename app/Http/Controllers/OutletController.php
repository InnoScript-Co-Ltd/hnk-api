<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutletStoreRequest;
use App\Http\Requests\OutletUpdateRequest;
use App\Models\Outlet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{
    public function index()
    {
        DB::beginTransaction();

        try {
            $outlets = Outlet::searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
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
            $outlet = Outlet::findOrFail($id);
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

            $outlet = Outlet::findOrFail($id);

            $outlet->update($payload->toArray());

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
            $outlet->delete($id);
            DB::commit();

            return $this->success('Outlet is deleted successfully', $outlet);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
