<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;

class HomeController extends Controller
{
    public function index(Request $request) {
        
        return view('web.home.home');
    }

    public function getBrand(Request $request) {
        $brands = Brand::query()->where('category_id', $request->category_id)->where('status', 1)->get();
        return response()->json([
            'status' => 'success',
            'brands' => $brands
        ], 200);
    }
}
