<?php

namespace App\Services;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;

class ShowProvinceService
{
    public function showProvince($province_id, $district_id, $ward_id) {
        $province= Province::find($province_id);
        $province_name = $province ? $province->province_name : 'Không xác định';
        $district = District::find($district_id);
        $district_name = $district ? $district->district_name : 'Không xác định';
        $ward = Ward::find($ward_id);
        $ward_name = $ward ? $ward->ward_name : 'Không xác định';
        return ['province_name' => $province_name, 'district_name' => $district_name, 'ward_name' => $ward_name];
    }
}