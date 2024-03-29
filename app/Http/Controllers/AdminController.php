<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\Admin;
use Exception;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        DB::beginTransaction();

        try {
            $admin = Admin::with(['image'])
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Admin list is successfully retrived', $admin);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store(AdminStoreRequest $request)
    {
        $payload = collect($request->validated());

        try {
            $admin = Admin::create($payload->toArray());
            DB::commit();

            return $this->success('Admin is created successfully', $admin);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $admin = Admin::with(['image'])->findOrFail($id);
            DB::commit();

            return $this->success('Admin detail is successfully retrived', $admin);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(AdminUpdateRequest $request, $id)
    {

        $payload = collect($request->validated());
        DB::beginTransaction();
        try {

            $admin = Admin::findOrFail($id);

            if (isset($payload['profile'])) {
                $imagePath = $payload['profile']->store('images', 'public');
                $profileImage = explode('/', $imagePath)[1];
                $admin->image()->updateOrCreate(['imageable_id' => $admin->id], [
                    'image' => $profileImage,
                    'imageable_id' => $admin->id,
                ]);
            }

            $admin->update($payload->toArray());

            DB::commit();

            return $this->success('Admin is updated successfully', $admin);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $admin = Admin::findOrFail($id);
            $admin->delete($id);
            DB::commit();

            return $this->success('Admin is deleted successfully', $admin);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
