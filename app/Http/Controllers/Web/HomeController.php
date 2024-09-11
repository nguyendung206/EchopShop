<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Users;
use App\Services\HomeService;
use Illuminate\Http\Request;
use App\Enums\TypeProduct;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index(Request $request)
    {
        $favorites = [];
        if(Auth::check()) {
            $user = Auth::user(); 
            $userWithFavorites = Users::query()->where('id', $user->id)->with('favorites')->first();
            $favorites = $userWithFavorites->favorites;
        }
        $banners = Banner::query()->where('status', 1)->orderBy('display_order', 'asc')->limit(4)->get();
        $secondhandProducts = $this->homeService->getProduct(TypeProduct::SECONDHAND->value, 8, 'secondhandPage');
        $exchangeProducts = $this->homeService->getProduct(TypeProduct::EXCHANGE->value, 8, 'exchangePage');
        
        if ($request->ajax() || $request->wantsJson()) {
            $productHtml = '';
            $hasMorePage = false;
            if($request->query('secondhandPage')){
                $productHtml = view('web.home.moreSecondhand', compact('secondhandProducts', 'favorites'))->render();
                $hasMorePage = ! $secondhandProducts->hasMorePages();
            }
            if($request->query('exchangePage')) {
                $productHtml = view('web.home.moreExchange', compact('exchangeProducts', 'favorites'))->render();
                $hasMorePage = ! $exchangeProducts->hasMorePages();
            }
            return response()->json([
                'products' => $productHtml,
                'hasMorePage' => $hasMorePage,
            ]);

        }

        return view('web.home.home', compact('banners', 'secondhandProducts', 'exchangeProducts', 'favorites'));
    }
}
