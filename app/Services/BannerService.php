<?php

namespace App\Services;

use App\Models\Banner;
use Exception;

class BannerService
{
    public function index($request)
    {
        $query = Banner::query();
        if (! empty($request->search)) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }
        if (isset($request->status)) {
            $query->where('status', $request->status);
        }

        return $query->paginate(5);
    }

    public function store($request)
    {
        $display_order = $request->display_order;
        if (! $request->display_order) {
            $maxDisplayOrder = Banner::max('display_order');
            $display_order = $maxDisplayOrder + 1;
        }
        $bannerData = [
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'display_order' => $display_order,
            'link' => $request->link,
            'photo' => uploadImage($request->file('photo'), 'upload/banners/', 'nobanner.png'),
        ];

        return Banner::create($bannerData);
    }

    public function update($request, $id)
    {
        $banner = Banner::findOrFail($id);

        $photo = $banner->photo;
        $display_order = $request->display_order;
        if (! $request->display_order) {
            $maxDisplayOrder = Banner::max('display_order');
            $display_order = $maxDisplayOrder + 1;
        }
        $bannerData = [
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'display_order' => $display_order,
            'link' => $request->link,
            'photo' => uploadImage($request->file('photo'), 'upload/banners/', $photo),
        ];
        $banner->update($bannerData);
        if ($request->file('photo')) {
            deleteImage($photo, 'nobanner.png');

        }

        return $banner;
    }

    public function destroy($id)
    {
        try {
            $banner = Banner::findOrFail($id);
            $check = $banner->delete();
            if ($check) {
                deleteImage($banner->photo, 'nobanner.png');
            }

            return $check;
        } catch (Exception $e) {
            return false;
        }
    }
}
