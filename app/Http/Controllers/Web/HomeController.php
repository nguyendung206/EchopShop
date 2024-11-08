<?php

namespace App\Http\Controllers\Web;

use App\Enums\Status;
use App\Enums\TypeProduct;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
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
        $brands = Brand::query()->where('status', 1)->limit(12)->get();
        $banners = Banner::query()->where('status', 1)->orderBy('display_order', 'asc')->limit(4)->get();
        $secondhandProducts = $this->homeService->getProduct(TypeProduct::SECONDHAND->value, 10, 'secondhandPage');
        $exchangeProducts = $this->homeService->getProduct(TypeProduct::EXCHANGE->value, 10, 'exchangePage');
        $saleProducts = $this->homeService->getProduct(TypeProduct::SALE->value, 10, 'salePage');
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

            if ($request->query('salePage')) {
                $productHtml = view('web.product.listSecondhandProduct', ['secondhandProducts' => $saleProducts])->render();
                $hasMorePage = ! $saleProducts->hasMorePages();
            }

            return response()->json([
                'products' => $productHtml,
                'hasMorePage' => $hasMorePage,
            ]);
        }

        return view('web.home.home', compact('brands', 'banners', 'secondhandProducts', 'exchangeProducts', 'giveawayProducts', 'saleProducts'));
    }

    public function filterProducts(Request $request)
    {
        $categories = Category::where('status', Status::ACTIVE)->get();
        $brands = Brand::where('status', Status::ACTIVE)->get();
        $products = $this->homeService->filterProducts($request->all());
        $provinces = Province::query()->get();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'productHtml' => view('web.product.listProduct', compact('products'))->render(),
                'hasMorePages' => $products->hasMorePages(),
            ]);
        }

        $queryParams = $request->query();
        if (isset($queryParams['type'])) {
            $queryParams = [0 => $queryParams['type']];

            return view('web.product.productPage', [
                'products' => $products,
                'categories' => $categories,
                'brands' => $brands,
                'provinces' => $provinces,
            ])->withQueryString($queryParams);
        }

        return view('web.product.productPage', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'provinces' => $provinces,
        ]);

    }

    public function search(Request $request)
    {
        $datas = $this->homeService->search($request->all());

        return response()->json([
            'resultHtml' => view('web.UI.resultSearch', ['products' => $datas['products'], 'brands' => $datas['brands']])->render(),
        ]);
    }
}
