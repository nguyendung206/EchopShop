<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Banner;
use App\Enums\TypeProduct;

class HomeController extends Controller
{
    public function index(Request $request) {
        $banners = Banner::query()->where('status', 1)->orderBy('display_order', 'asc')->limit(4)->get();
        $secondhandProducts = Product::query()->where('status', 1)->where('type', TypeProduct::SECONDHAND->value)->limit(8)->get();
        
        return view('web.home.home', compact('banners', 'secondhandProducts'));
    }
}
