<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromotionSliderStoreRequest;
use App\Http\Requests\PromotionSliderUpdateRequest;
use App\Models\PromotionSlider;
use Exception;
use Illuminate\Support\Facades\DB;

class PromotionSliderController extends Controller
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
            $promotionSliders = PromotionSlider::where($this->active)
                ->with(['image'])
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Promotion slider list is successfully retrived', $promotionSliders);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store(PromotionSliderStoreRequest $request)
    {
        $payload = collect($request->validated());

        try {
            $promotion = PromotionSlider::create($payload->toArray());
            $imagePath = $payload['image']->store('images', 'public');
            $promotionSliderImage = explode('/', $imagePath)[1];
            $promotion->image()->create(['image' => $promotionSliderImage]);
            $promotion['image'] = $promotionSliderImage;
            DB::commit();

            return $this->success('Promotion is created successfully', $promotion);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $promotion = PromotionSlider::where($this->active)->with(['image'])->findOrFail($id);
            DB::commit();

            return $this->success('Promotion slider detail is successfully retrived', $promotion);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(PromotionSliderUpdateRequest $request, $id)
    {

        $payload = collect($request->validated());
        DB::beginTransaction();
        try {

            $promotion = PromotionSlider::findOrFail($id);

            $promotion->update($payload->toArray());
            if (isset($payload['image'])) {
                $imagePath = $payload['image']->store('images', 'public');
                $promotionSliderImage = explode('/', $imagePath)[1];
                $promotion->image()->create(['image' => $promotionSliderImage]);
                $promotion['image'] = $promotionSliderImage;
            }
            DB::commit();

            return $this->success('Promotion slider is updated successfully', $promotion);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $promotion = PromotionSlider::findOrFail($id);
            $promotion->delete();
            DB::commit();

            return $this->success('Promotion slider is deleted successfully', $promotion);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
