<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Banner;
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
        $secondhandProducts = $this->homeService->moreSecondhand($request);
        $exchangeProducts = $this->homeService->moreExchange($request);
        
        if ($request->ajax() || $request->wantsJson()) {
            $productHtml = '';
            $hasMorePage = false;
            if($request->query('secondhandPage')){
                $productHtml = view('web.home.moreSecondhand', compact('secondhandProducts'))->render();
                $hasMorePage = ! $secondhandProducts->hasMorePages();
            }
            if($request->query('exchangePage')) {
                $productHtml = view('web.home.moreExchange', compact('exchangeProducts'))->render();
                $hasMorePage = ! $exchangeProducts->hasMorePages();
            }
            return response()->json([
                'products' => $productHtml,
                'hasMorePage' => $hasMorePage,
            ]);

        }

        return view('web.home.home', compact('banners', 'secondhandProducts', 'exchangeProducts'));
    }
}
