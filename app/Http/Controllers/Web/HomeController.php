<?php

namespace App\Http\Controllers\Web;

use App\Enums\TypeProduct;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Province;
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
        $secondhandProducts = $this->homeService->getProduct(TypeProduct::SECONDHAND->value, 8, 'secondhandPage');
        $exchangeProducts = $this->homeService->getProduct(TypeProduct::EXCHANGE->value, 8, 'exchangePage');
        $partners = Partner::query()->where('status', 1)->get();
        $giveawayProducts = Product::query()->where('status', 1)->where('type', TypeProduct::GIVEAWAY)->get();

        if ($request->ajax() || $request->wantsJson()) {
            $productHtml = '';
            $hasMorePage = false;
            if ($request->query('secondhandPage')) {
                $productHtml = view('web.home.moreSecondhand', compact('secondhandProducts'))->render();
                $hasMorePage = ! $secondhandProducts->hasMorePages();
            }
            if ($request->query('exchangePage')) {
                $productHtml = view('web.home.moreExchange', compact('exchangeProducts'))->render();
                $hasMorePage = ! $exchangeProducts->hasMorePages();
            }

            return response()->json([
                'products' => $productHtml,
                'hasMorePage' => $hasMorePage,
            ]);

        }

        return view('web.home.home', compact('banners', 'secondhandProducts', 'exchangeProducts', 'giveawayProducts', 'partners'));
    }

    public function filterProducts(Request $request) {
        $data = $this->homeService->filterProducts($request);
        $products = $data['products'];
        $provinces = Province::query()->get();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(
                $data
            );
        }

        return view('web.product.exchangeProduct', compact('products', 'provinces'));
    }
}
