<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Shop;
use App\Models\Brand;

class HomeController extends Controller
{
    public function index(Request $request) {
        $categories =  Category::query()->where('status', 1)->with('brands')->limit(9)->get();
        $shop = Shop::query()->first();
        return view('web.home.home', compact('categories', 'shop'));
    }

    public function getBrand(Request $request) {
        $brands = Brand::query()->where('category_id', $request->category_id)->get();
        return response()->json([
            'status' => 'success',
            'brands' => $brands
        ], 200);
    }
}
