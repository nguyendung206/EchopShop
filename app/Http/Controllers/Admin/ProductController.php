<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use App\Services\StatusService;
use Exception;
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

    public function create()
    {
        $categories = Category::where('status', Status::ACTIVE)->get();
        $brands = Brand::where('status', Status::ACTIVE)->get();

        return view('admin.product.create', compact('categories', 'brands'));
    }

    public function store(ProductRequest $request)
    {
        try {
            $product = $this->productService->createProduct($request);

            if ($product) {
                $colors = $request->input('colors', []);
                $sizes = $request->input('sizes', []);
                $quantities = $request->input('quantities', []);

                foreach ($colors as $index => $color) {
                    $this->productService->createProductUnit([
                        'product_id' => $product->id,
                        'color' => $color ?? '',
                        'size' => $sizes[$index] ?? '',
                        'quantity' => $quantities[$index] ?? 0,
                    ]);
                }

                flash('Thêm mới sản phẩm thành công!')->success();

                return redirect()->route('admin.product.index');
            } else {
                flash('Không thể tạo sản phẩm, vui lòng thử lại.')->error();

                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            flash('Đã xảy ra lỗi, vui lòng thử lại.')->error();

            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        if (! $product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $categories = Category::where('status', Status::ACTIVE)->get();
        $brands = Brand::where('status', Status::ACTIVE)->get();

        return view('admin.product.edit', compact('product', 'categories', 'brands'));
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
                foreach ($colors as $index => $color) {
                    $details[] = [
                        'color' => $color ?? '',
                        'size' => $sizes[$index] ?? '',
                        'quantity' => $quantities[$index] ?? 0,
                    ];
                }
                $this->productService->updateProductUnit($details, $id);

                flash('Cập nhật sản phẩm thành công!')->success();

                return redirect()->route('admin.product.index');
            } else {
                flash('Không thể cập nhật sản phẩm, vui lòng thử lại.')->error();

                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            flash('Đã xảy ra lỗi, vui lòng thử lại.')->error();

            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            if ($this->productService->deleteProduct($id)) {
                flash('Xóa sản phẩm thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa sản phẩm!')->error();
            }
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa sản phẩm!')->error();
        }

        return redirect()->route('admin.product.index');
    }

    public function status($id)
    {
        try {
            $product = Product::findOrFail($id);
            $this->statusService->changeStatus($product);
            flash('Thay đổi trạng thái thành công')->success();
        } catch (\Exception $e) {
            flash('Đã có lỗi xảy ra khi thay đổi trạng thái')->error();

            return redirect()->route('admin.product.index');
        }

        return redirect()->route('admin.product.index');
    }

    public function show($id)
    {
        $product = Product::where('id', $id)->first();

        return view('admin.product.show', compact('product'));
    }
}
