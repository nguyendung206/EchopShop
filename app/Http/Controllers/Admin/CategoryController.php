<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function Index()
    {
        $datas = Category::paginate(5);
        return view('Admin.Category.Index', compact('datas'))->with('i', (request()->input('page', 1) - 1) * 9);
    }

    public function Create()
    {
        return view('Admin.Category.Create');
    }

    public function SaveCreate(CreateCategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('upload/product'), $fileName);
            $category->photo = $fileName;
        } else {
            $category->photo = 'noproduct.png';
        }

        $category->save();

        flash('Thêm mới loại hàng thành công!')->success();
        return redirect()->route('category.index');
    }

    public function Update($id)
    {
        $category = Category::where('id', $id)->first();
        return view('Admin.Category.Update', compact('category'));
    }

    public function SaveUpdate(CreateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('upload/product'), $fileName);
            $category->photo = $fileName;
        } elseif (!$category->photo) {
            $category->photo = 'noproduct.png';
        }
        $category->save();

        flash('Cập nhật loại hàng thành công!')->success();
        return redirect()->route('category.index');
    }

    public function delete($id)
    {
        try {
            $category = Category::findOrFail($id);
            if ($category->photo && $category->photo != 'noproduct.png') {
                $oldImage = public_path('upload/product/') . $category->photo;
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            $category->delete();

            flash('Xóa loại hàng thành công!')->success();
        } catch (\Exception $e) {
            flash('Đã xảy ra lỗi khi xóa loại hàng!')->error();
        }

        return redirect()->route('category.index');
    }
}
