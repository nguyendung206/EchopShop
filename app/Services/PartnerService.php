<?php

namespace App\Services;

use App\Models\Partner;

class PartnerService
{
    public function index($request)
    {
        $query = Partner::query();
        if (! empty($request->search)) {
            $query->where('company_name', 'like', '%'.$request->search.'%');
        }
        if (isset($request->status)) {
            $query->where('status', $request->status);
        }

        return $query->paginate(5);
    }

    public function store($request)
    {
        $PartnerData = [
            'company_name' => $request->company_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'photo' => uploadImage($request->file('photo'), 'upload/Partners/', 'nophoto.png'),
            'status' => $request->status,
        ];
        return Partner::create($PartnerData);
    }

    public function update($request, $id)
    {
        $partner = Partner::findorfail($id);
        $photo = $partner->photo;
        $PartnerData = [
            'company_name' => $request->company_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'photo' => uploadImage($request->file('photo'), 'upload/Partners/', $photo),
            'status' => $request->status,
        ];
        $partner->update($PartnerData);
        if ($request->file('photo')) {
            deleteImage($photo, 'nophoto.png');
        }
        return $partner;
    }

    public function destroy($id)
    {
        try {
            $partner = Partner::findOrFail($id);
            $check = $partner->delete();
            if($check) {
                deleteImage($partner->photo, 'nophoto.png');
            }
            return $check;
        }catch (Exception $e) {
            return false;
        }
    }
}
