<?php

namespace App\Http\Controllers\web;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Province;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        try {
            $datas = $this->productService->getPosts(10);
            if ($request->ajax()) {
                $productHtml = view('web.profile.morePost', compact('datas'))->render();
                $hasMorePage = $datas->hasMorePages();

                return response()->json([
                    'posts' => $productHtml,
                    'hasMorePage' => $hasMorePage,
                ]);
            }

            return view('web.profile.postmanage', compact('datas'));
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi tải danh sách bài viết!')->error();

            return redirect()->back();
        }
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();

        return view('web.product.productdetail', compact('product'));
    }

    public function create()
    {
        $categories = Category::where('status', Status::ACTIVE)->get();
        $brands = Brand::where('status', Status::ACTIVE)->get();

        return view('web.product.post', compact('categories', 'brands'));
    }

    public function store(ProductRequest $request)
    {
        try {
            $product = $this->productService->createProduct($request);

            if ($product) {
                $colors = $request->input('colors', []);
                $sizes = $request->input('sizes', []);
                $quantities = $request->input('quantities', []);

                foreach ($quantities as $index => $quantity) {
                    $this->productService->createProductUnit([
                        'product_id' => $product->id,
                        'color' => $colors[$index] ?? '',
                        'size' => $sizes[$index] ?? '',
                        'quantity' => $quantity ?? 1,
                    ]);
                }

                return redirect()->route('post.create')
                    ->with('success', 'Đăng bài thành công! Vui lòng chờ kiểm duyệt!');
            } else {
                return redirect()->back()->with('error', 'Đăng bài thất bại.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi, vui lòng thử lại.');
        }
    }

    public function edit($id)
    {
        $post = Product::where('id', $id)->first();
        if (! $post) {
            return redirect()->back()->with('error', 'Bài viết không tìm thấy.');
        }

        $categories = Category::where('status', Status::ACTIVE)->get();
        $brands = Brand::where('status', Status::ACTIVE)->get();

        return view('web.product.editpost', compact('post', 'categories', 'brands'));
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $product = $this->productService->updateProduct($request, $id);

            if ($product) {
                $colors = $request->input('colors', []);
                $sizes = $request->input('sizes', []);
                $quantities = $request->input('quantities', []);

                $details = [];
                foreach ($quantities as $index => $quantity) {
                    $details[] = [
                        'color' => $colors[$index] ?? '',
                        'size' => $sizes[$index] ?? '',
                        'quantity' => $quantity ?? 1,
                    ];
                }
                $this->productService->updateProductUnit($details, $id);

                return redirect()->route('post.index')
                    ->with('success', 'Cập nhật bài viết thành công!');
            } else {
                return redirect()->back()->withInput()
                    ->with('error', 'Không thể cập nhật bài viết, vui lòng thử lại.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Đã xảy ra lỗi, vui lòng thử lại.');
        }
    }

    public function destroy($id)
    {
        try {
            if ($this->productService->deleteProduct($id)) {
                return redirect()->back()->with('success', 'Xóa bài viết thành công!');
            } else {
                return redirect()->back()->with('error', 'Đã xảy ra lỗi, vui lòng thử lại.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi, vui lòng thử lại.');
        }
    }

    public function filterByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $this->productService->filterByCategory($category->id);
        $provinces = Province::all();

        return view('web.product.product', compact('products', 'category', 'provinces'));
    }

    public function filterByCategoryAndBrand($categorySlug, $brandSlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $brand = Brand::where('slug', $brandSlug)->firstOrFail();
        $products = $this->productService->filterByCategoryAndBrand($category->id, $brand->id);
        $provinces = Province::all();

        return view('web.product.product', compact('products', 'category', 'brand', 'provinces'));
    }

    public function filterProducts(Request $request)
    {
        $selectedCategories = $request->input('categories', []);
        $selectedBrands = $request->input('brands', []);
        $selectedProvinces = $request->input('provinces', []);
        $rangeInputMin = $request->input('rangeInputMin', null);
        $rangeInputMax = $request->input('rangeInputMax', null);
        $provinces = Province::all();

        $category = Category::whereIn('id', $selectedCategories)->pluck('name')->toArray();
        $brand = Brand::whereIn('id', $selectedBrands)->pluck('name')->toArray();

        $products = $this->productService->filterProducts($selectedCategories, $selectedBrands, $selectedProvinces, $rangeInputMin, $rangeInputMax);

        return response()->json([
            'productHtml' => view('web.product.product_list', compact('products', 'provinces'))->render(),
            'categoryNames' => $category,
            'brandNames' => $brand,
        ]);
    }
}
