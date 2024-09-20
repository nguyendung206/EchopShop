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
                'start_date' => $request->startDate,
                'end_date' => $request->endDate,
                'max_uses' => $request->maxUses,
                'limit_uses' => $request->limitUses,
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
        $discountData = [
            'title' => $request->title,
            'description' => $request->description,
            'code' => $request->code,
            'type' => $request->type,
            'value' => $request->value,
            'start_date' => $request->startDate,
            'end_date' => $request->endDate,
            'max_uses' => $request->maxUses,
            'limit_uses' => $request->limitUses,
        ];
        $discount->update($discountData);

        return $discount;
    }

    public function destroy($id)
    {
        try {
            $discount = Discount::findOrFail($id);
            $check = $discount->delete();

            return $check;
        } catch (Exception $e) {
            return false;
        }
    }
}
