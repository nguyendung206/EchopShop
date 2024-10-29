<?php

namespace App\Services;

use App\Http\Requests\FeeshipRequest;
use App\Models\Feeship;
use App\Models\Province;

class FeeshipService
{
    public function getFeeships($request)
    {
        $query = Province::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('province_name', 'like', '%'.$searchTerm.'%');
            });
        }
        if ($request->has('province_id') && $request->province_id != '') {
            $query->where('id', $request->province_id);
        }

        return $query->paginate(10);
    }

    public function createFeeship(FeeshipRequest $request)
    {
        $feeship = new Feeship;
        $feeship->feename = $request->feename;
        $feeship->feeship = $request->feeship;
        $feeship->description = $request->description;
        $feeship->province_id = $request->province_id;
        $feeship->district_id = $request->district_id;
        $feeship->ward_id = $request->ward_id;
        $feeship->save();

        return $feeship;
    }

    // public function updateBrand(FeeshipRequest $request)
    // {
    //     $feeship = Feeship::findOrFail($request->id);
    //     $feeship->feename = $request->feename;
    //     $feeship->feeship = $request->feeship;
    //     $feeship->description = $request->description;

    //     $feeship->save();

    //     return $feeship;
    // }

    public function deleteFeeShip($id)
    {
        try {
            $feeship = Feeship::findOrFail($id);
            $feeship->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}