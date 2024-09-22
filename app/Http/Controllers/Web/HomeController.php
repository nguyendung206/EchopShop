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
        $secondhandProducts = $this->homeService->getProduct(TypeProduct::SECONDHAND->value, 10, 'secondhandPage');
        $exchangeProducts = $this->homeService->getProduct(TypeProduct::EXCHANGE->value, 10, 'exchangePage');
        $giveawayProducts = Product::query()->where('status', 1)->where('type', TypeProduct::GIVEAWAY)->get();

        if ($request->ajax() || $request->wantsJson()) {
            $productHtml = '';
            $hasMorePage = false;
            if ($request->query('secondhandPage')) {
                $productHtml = view('web.product.listSecondhandProduct', compact('secondhandProducts'))->render();
                $hasMorePage = ! $secondhandProducts->hasMorePages();
            }
            if ($request->query('exchangePage')) {
                $productHtml = view('web.product.listExchangeProduct', compact('exchangeProducts'))->render();
                $hasMorePage = ! $exchangeProducts->hasMorePages();
            }

            return response()->json([
                'products' => $productHtml,
                'hasMorePage' => $hasMorePage,
            ]);

        }

        return view('web.home.home', compact('banners', 'secondhandProducts', 'exchangeProducts', 'giveawayProducts'));
    }

    public function filterProducts(Request $request)
    {
        $type = null;
        $currentUrl = $request->url();
        switch (true) {
            case stripos($currentUrl, 'exchange') !== false:
                $type = TypeProduct::EXCHANGE;
                break;
            case stripos($currentUrl, 'secondhand') !== false:
                $type = TypeProduct::SECONDHAND;
                break;
            case stripos($currentUrl, 'giveaway') !== false:
                $type = TypeProduct::GIVEAWAY;
                break;
            default:
                break;
        }

        $products = $this->homeService->filterProducts($request, $type);
        $provinces = Province::query()->get();
        if ($request->ajax() || $request->wantsJson()) {
            
            return response()->json([
                'productHtml' => view('web.product.listProduct', compact('products'))->render(),
            ]);
        }

        return view('web.product.productPage', compact('products', 'provinces'));
    }
}
