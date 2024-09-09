<?php

namespace App\Http\Controllers\Web;

use App\Enums\TypeProduct;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use App\Services\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index(Request $request)
    {
        $banners = Banner::query()->where('status', 1)->orderBy('display_order', 'asc')->limit(4)->get();
        $secondhandProducts = Product::query()->where('status', 1)->where('type', TypeProduct::SECONDHAND->value)->limit(8)->get();
        $moreSecondhand = $request->query('moreSecondhand', 1);

        return view('web.home.home', compact('banners', 'secondhandProducts', 'moreSecondhand'));
    }

    public function moreSecondhand(Request $request)
    {
        $jsonResult = $this->homeService->moreSecondhand($request);

        return $jsonResult;
    }
}
