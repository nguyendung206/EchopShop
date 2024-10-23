<?php

namespace App\Services;

use App\Models\Feeship;

class FeeshipService
{
    public function getFeeships($request)
    {
        $query = Feeship::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('feename', 'like', '%'.$searchTerm.'%');
            });
        }

        return $query->paginate(10);
    }

    // public function createBrand(BrandRequest $request)
    // {
    //     $brand = new Brand;
    //     $brand->name = $request->name;
    //     $brand->description = $request->description;
    //     $brand->status = $request->status;
    //     $brand->category_id = $request->category_id;

    //     if ($request->hasFile('photo')) {
    //         $brand->photo = uploadImage($request->file('photo'), 'upload/brand/');
    //     } else {
    //         $brand->photo = 'noproduct.png';
    //     }

    //     $brand->save();

    //     return $brand;
    // }

    // public function updateBrand(BrandRequest $request, $id)
    // {
    //     $brand = Brand::findOrFail($id);
    //     $brand->name = $request->name;
    //     $brand->description = $request->description;
    //     $brand->status = $request->status;
    //     $brand->category_id = $request->category_id;

    //     if ($request->hasFile('photo')) {
    //         $brand->photo = uploadImage($request->file('photo'), 'upload/brand/', $brand->photo);
    //     }

    //     $brand->save();

    //     return $brand;
    // }

    // public function deleteBrand($id)
    // {
    //     try {
    //         $brand = Brand::findOrFail($id);
    //         if ($brand->photo && $brand->photo != 'noproduct.png') {
    //             deleteImage($brand->photo);
    //         }

    //         $brand->delete();

    //         return true;
    //     } catch (\Exception $e) {
    //         return false;
    //     }
    // }
}
