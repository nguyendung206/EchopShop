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

    public function getDiscountJson($request)
    {
        try {
            $userProvinceId = $request['province_id'];
            $userDistrictId = $request['district_id'];
            $userWardId = $request['ward_id'];
            $userId = $request['user_id'];
            $vouchers = Discount::query()
                ->where('status', Status::ACTIVE)
                ->where('end_time', '>=', Carbon::now('Asia/Bangkok'))
                ->where('start_time', '<=', Carbon::now('Asia/Bangkok'))
                ->where(function ($query) use ($userProvinceId, $userDistrictId, $userWardId) {
                    $query->where('scope_type', '<>', TypeDiscountScope::REGIONAL->value)
                        ->orWhere(function ($subQuery) use ($userProvinceId, $userDistrictId, $userWardId) { // regional type
                            $subQuery->where('scope_type', TypeDiscountScope::REGIONAL->value)
                                ->where('province_id', $userProvinceId) //province
                                ->where(function ($innerSubQuery) use ($userDistrictId, $userWardId) {
                                    $innerSubQuery->where(function ($districtQuery) use ($userDistrictId) { // district
                                        $districtQuery->where('district_id', $userDistrictId)
                                            ->orWhereNull('district_id');
                                    })
                                        ->where(function ($wardQuery) use ($userWardId) {   // ward
                                            $wardQuery->where('ward_id', $userWardId)
                                                ->orWhereNull('ward_id');
                                        });
                                });
                        });
                })
                ->with(['ward', 'district', 'province'])
                ->get()
                ->filter(function ($voucher) use ($userId) {  // lấy hết danh sách rồi lọc
                    $userUsed = explode(',', $voucher->user_used);
                    $countUser = array_count_values($userUsed);   // đưa phần tử thành key và số lần xuất hiện thành value
                    return ! isset($countUser[$userId]) || $countUser[$userId] < $voucher->limit_uses;
                })
                ->values();
            return $vouchers;
        } catch (\Exception $e) {
            dd($e);
            return false;
        }
    }
}
