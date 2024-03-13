<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        DB::beginTransaction();

        try {
            $user = User::with(['image'])
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('User list is successfully retrived', $user);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store(UserStoreRequest $request)
    {

        $payload = collect($request->validated());

        try {
            $payload['token_expired'] = Carbon::now()->addYear();

            // $jsonEncode = json_encode($payload->toArray(), true);

            $payload['token'] = Crypt::encrypt($payload['email']);
            $user = User::create($payload->toArray());
            DB::commit();

            return $this->success('User is created successfully', $user);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $user = User::with(['image'])->findOrFail($id);
            DB::commit();

            return $this->success('User detail is successfully retrived', $user);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {

        $payload = collect($request->validated());
        DB::beginTransaction();
        try {

            $user = User::findOrFail($id);

            if (isset($payload['profile'])) {
                $imagePath = $payload['profile']->store('images', 'public');
                $profileImage = explode('/', $imagePath)[1];
                $user->image()->updateOrCreate(['imageable_id' => $user->id], [
                    'image' => $profileImage,
                    'imageable_id' => $user->id,
                ]);
            }

            $user->update($payload->toArray());

            DB::commit();

            return $this->success('User is updated successfully', $user);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $user = User::findOrFail($id);
            $user->delete($id);
            DB::commit();

            return $this->success('User is deleted successfully', $user);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
