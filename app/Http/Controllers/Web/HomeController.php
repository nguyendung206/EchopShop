<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $banners = Banner::query()->where('status', 1)->orderBy('display_order', 'asc')->limit(4)->get();

        return view('web.home.home', compact('banners'));
    }
}
