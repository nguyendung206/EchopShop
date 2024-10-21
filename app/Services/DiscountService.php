<?php

namespace App\Services;

use App\Enums\Status;
use App\Enums\TypeDiscountScope;
use App\Models\Discount;
use Carbon\Carbon;
use Exception;

class DiscountService
{
    public function index($request)
    {
        $query = Discount::query();
        if (! empty($request['search'])) {
            $query->where('title', 'like', '%'.$request['search'].'%');
        }
        if (isset($request['status'])) {
            if ($request['status'] == 1) {
                $query->where('end_time', '>=', now());
            } else {
                $query->where('end_time', '<', now());
            }
        }

        return $query->paginate(10);
    }

    public function store($request)
    {
        try {
            if (! isset($request['photo'])) {
                $request['photo'] = null;
            }
            $discountData = [
                'title' => $request['title'],
                'description' => $request['description'],
                'code' => $request['code'],
                'type' => $request['type'],
                'value' => $request['value'],
                'max_value' => $request['maxValue'],
                'start_time' => $request['startTime'],
                'end_time' => $request['endTime'],
                'max_uses' => $request['maxUses'],
                'limit_uses' => $request['limitUses'],
                'photo' => uploadImage($request['photo'], 'upload/discounts/', 'nodiscount.png'),
                'status' => $request['status'],
                'scope_type' => $request['scope_type'],
            ];

            if ($request['scope_type'] == TypeDiscountScope::REGIONAL->value) {
                $discountData['province_id'] = $request['province_id'];
                if (! empty($request['district_id'])) {
                    $discountData['district_id'] = $request['district_id'];
                }

                if (! empty($request['ward_id'])) {
                    $discountData['ward_id'] = $request['ward_id'];
                }
            }
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
        if (! isset($request['photo'])) {
            $request['photo'] = null;
        }
        $discountData = [
            'title' => $request['title'],
            'description' => $request['description'],
            'code' => $request['code'],
            'type' => $request['type'],
            'value' => $request['value'],
            'max_value' => $request['maxValue'],
            'start_time' => $request['startTime'],
            'end_time' => $request['endTime'],
            'max_uses' => $request['maxUses'],
            'limit_uses' => $request['limitUses'],
            'photo' => uploadImage($request['photo'], 'upload/discounts/', 'nodiscount.png'),
            'status' => $request['status'],
            'scope_type' => $request['scope_type'],
        ];
        if ($request['scope_type'] == TypeDiscountScope::REGIONAL->value) {
            $discountData['province_id'] = $request['province_id'];
            $discountData['district_id'] = $request['district_id'];
            $discountData['ward_id'] = $request['ward_id'];
        } else {
            $discountData['province_id'] = null;
            $discountData['district_id'] = null;
            $discountData['ward_id'] = null;
        }
        $discount->update($discountData);
        if ($request['photo']) {
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

    public function getDiscountJson()
    {
        try {
            $discounts = Discount::query()
                ->with(['province', 'district', 'ward'])
                ->where('status', Status::ACTIVE)
                ->where('end_time', '>=', Carbon::now('Asia/Bangkok'))
                ->where('start_time', '<=', Carbon::now('Asia/Bangkok'))->get();

            return $discounts;

        } catch (\Exception $e) {
            return $e;
        }
    }
}
