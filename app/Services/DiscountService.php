<?php

namespace App\Services;

use App\Models\Discount;
use Exception;

class DiscountService
{
    public function index($request)
    {
        $query = Discount::query();
        if (! empty($request->search)) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }
        if (isset($request->status)) {
            if ($request->status == 1) {
                $query->where('end_date', '>=', now());
            } else {
                $query->where('end_date', '<', now());
            }
        }

        return $query->paginate(10);
    }

    public function store($request)
    {
        try {
            $discountData = [
                'title' => $request->title,
                'description' => $request->description,
                'code' => $request->code,
                'type' => $request->type,
                'value' => $request->value,
                'max_value' => $request->maxValue,
                'start_time' => $request->startTime,
                'end_time' => $request->endTime,
                'max_uses' => $request->maxUses,
                'limit_uses' => $request->limitUses,
                'photo' => uploadImage($request->file('photo'), 'upload/discounts/', 'nodiscount.png'),
                'status' => $request->status,
            ];
            $discount = Discount::create($discountData);

            return $discount;
        } catch (Exception $e) {
            return $e;
        }

    }

    public function update($request, $id)
    {
        $discount = Discount::findOrFail($id);
        $photo = $discount->photo;
        $discountData = [
            'title' => $request->title,
            'description' => $request->description,
            'code' => $request->code,
            'type' => $request->type,
            'value' => $request->value,
            'max_value' => $request->maxValue,
            'start_time' => $request->startTime,
            'end_time' => $request->endTime,
            'max_uses' => $request->maxUses,
            'limit_uses' => $request->limitUses,
            'photo' => uploadImage($request->file('photo'), 'upload/discounts/', 'nodiscount.png'),
            'status' => $request->status,
        ];
        $discount->update($discountData);
        if ($request->file('photo')) {
            deleteImage($photo, 'nodiscount.png');

        }

        return $discount;
    }

    public function destroy($id)
    {
        try {
            $discount = Discount::findOrFail($id);
            $check = $discount->delete();
            if ($check) {
                deleteImage($discount->photo, 'nodiscount.png');
            }

            return $check;
        } catch (Exception $e) {
            return false;
        }
    }
}
