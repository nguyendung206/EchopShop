<?php

namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryService
{
    public function getCategories($request)
    {
        $query = Category::query();

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

        if ($request->ajax() || $request->wantsJson() || $request->is('api/*')) {
            return $query->get();
        }

        return $query->paginate(10);
    }

    public function createCategory(CategoryRequest $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;

        if ($request->hasFile('photo')) {
            $category->photo = uploadImage($request->file('photo'), 'upload/category/');
        } else {
            $category->photo = 'noproduct.png';
        }

        $category->save();

        return $category;
    }

    public function updateCategory(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;

        if ($request->hasFile('photo')) {
            $category->photo = uploadImage($request->file('photo'), 'upload/category/', $category->photo);
        }

        $category->save();

        return $category;
    }

    public function deleteCategory($id)
    {
        try {
            $category = Category::findOrFail($id);
            if ($category->photo && $category->photo != 'noproduct.png') {
                deleteImage($category->photo);
            }

            $category->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
