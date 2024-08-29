<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use App\Services\StatusService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    protected $statusService;

    public function __construct(ProductService $productService, StatusService $statusService)
    {
        $this->productService = $productService;
        $this->statusService = $statusService;
    }

    public function index(Request $request)
    {
        $datas = $this->productService->getProducts($request);
        return view('admin.product.index', compact('datas'));
    }

    public function Create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.create', compact('categories', 'brands'));
    }

    public function SaveCreate(ProductRequest $request)
    {
        $this->productService->createProduct($request);
        flash('Thêm mới sản phẩm thành công!')->success();
        return redirect()->route('product.index');
    }

    public function SaveUpdate(ProductRequest $request, $id)
    {
        $this->productService->updateProduct($request, $id);
        flash('Cập nhật sản phẩm thành công!')->success();
        return redirect()->route('product.index');
    }

    public function Update($id)
    {
        $product = Product::where('id', $id)->first();
        $categories = Category::all();
        $brands = Brand::all();
        return view('Admin.Product.Update', compact('product','categories', 'brands'));
    }

    public function Status($id)
    {
        $product = Product::findOrFail($id);
        $this->statusService->changeStatus(($product));
        flash('Thay đổi trạng thái thành công')->success();
        return redirect()->route('product.index');
    }
}
