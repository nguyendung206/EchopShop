<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function Index()
    {
        $datas = Category::paginate(5);
        return view('Admin.Category.Index', compact('datas'))->with('i', (request()->input('page', 1) - 1) * 9);
    }

    public function Create() {
        return view('Admin.Category.Create');
    }
}
