<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Mail\ProductStatusMail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\NotificationService;
use App\Services\ProductService;
use App\Services\StatusService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    protected $productService;

    protected $notificationService;

    protected $statusService;

    public function __construct(ProductService $productService, StatusService $statusService, NotificationService $notificationService)
    {
        $this->productService = $productService;
        $this->statusService = $statusService;
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $datas = $this->productService->getProducts($request->all());

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

    public function userproduct(Request $request)
    {
        $datas = $this->productService->getProductsUser($request->all());

        return view('admin.userproduct.index', compact('datas'));
    }

    public function statususerproduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            $this->statusService->changeStatus($product);
            $isActive = $product->status->value === 1;
            $title = $isActive ? 'Sản phẩm đã được kích hoạt' : 'Sản phẩm đã bị vô hiệu hóa';
            $body = 'Sản phẩm "'.$product->name.'" đã thay đổi trạng thái.';
            $type = $isActive ? 1 : 2;

            Mail::to($product->shop->email)->send(new ProductStatusMail($product, $title, $body, $isActive));
            Mail::to($product->shop->user->email)->send(new ProductStatusMail($product, $title, $body, $isActive));

            $this->notificationService->createNotification([
                'user_id' => $product->shop->user->id,
                'type' => $type,
                'title' => $title,
                'body' => $body,
                'product_id' => $product->id,
            ]);

            flash('Thay đổi trạng thái thành công')->success();
        } catch (\Exception $e) {
            flash('Đã có lỗi xảy ra khi thay đổi trạng thái')->error();

            return redirect()->route('admin.userproduct.index');
        }

        return redirect()->route('admin.userproduct.index');
    }

    public function showuserproduct($id)
    {
        $product = Product::where('id', $id)->first();

        return view('admin.userproduct.show', compact('product'));
    }
}
