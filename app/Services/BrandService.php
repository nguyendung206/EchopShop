<?php

namespace App\Services;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;

class BrandService
{
    public function getBrands($request)
    {
        $query = Brand::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('description', 'like', '%'.$searchTerm.'%');
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        return $query->paginate(10);
    }

    public function createBrand(BrandRequest $request)
    {
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->status = $request->status;
        $brand->category_id = $request->category_id;

        if ($request->hasFile('photo')) {
            $brand->photo = uploadImage($request->file('photo'), 'upload/product');
        } else {
            $brand->photo = 'noproduct.png';
        }

        $brand->save();

        return $brand;
    }

    public function updateBrand(BrandRequest $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->status = $request->status;
        $brand->category_id = $request->category_id;

        if ($request->hasFile('photo')) {
            $brand->photo = uploadImage($request->file('photo'), 'upload/product', $brand->photo);
        }

        $brand->save();

        return $brand;
    }

    public function deleteBrand($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            if ($brand->photo && $brand->photo != 'noproduct.png') {
                deleteImage($brand->photo);
            }

            $brand->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
