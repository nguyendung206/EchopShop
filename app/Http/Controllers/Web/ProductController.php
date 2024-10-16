<?php

namespace App\Http\Controllers\web;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\WaitProduct;
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
        try {
            $searchpost = $request->input('searchpost');
            $datas = $this->productService->getPosts(10, $searchpost);

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
                if ($request->unittype == 1) {
                    $quantity = $request->quantity;

                    $this->productService->createProductUnit([
                        'type' => $request->unittype,
                        'product_id' => $product->id,
                        'color' => null,
                        'size' => null,
                        'quantity' => $quantity > 0 ? $quantity : 1,
                    ]);
                } elseif ($request->unittype == 2) {
                    $colors = $request->input('colors', []);
                    $sizes = $request->input('sizes', []);
                    $quantities = $request->input('quantities', []);

                    foreach ($quantities as $index => $quantity) {
                        $this->productService->createProductUnit([
                            'type' => $request->unittype,
                            'product_id' => $product->id,
                            'color' => $colors[$index] ?? '',
                            'size' => $sizes[$index] ?? '',
                            'quantity' => $quantity > 0 ? $quantity : 1,
                        ]);
                    }
                }

                return redirect()->route('post.create')
                    ->with('success', 'Đăng bài thành công! Vui lòng chờ kiểm duyệt!');
            } else {
                return redirect()->back()->with('error', 'Đăng bài thất bại.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi: '.$e->getMessage());
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

    public function waitcreate(Request $request)
    {
        try {
            $result = WaitProduct::where('product_id', $request->product_id)->exists();
            if (! $result) {
                $product = $this->productService->createwaitProduct($request);
                if ($product) {
                    if ($request->unittype == 1) {
                        $quantity = $request->quantity;

                        $this->productService->createWaitProductUnit([
                            'type' => $request->unittype,
                            'wait_product_id' => $product->id,
                            'color' => null,
                            'size' => null,
                            'quantity' => $quantity > 0 ? $quantity : 1,
                        ]);
                    } elseif ($request->unittype == 2) {
                        $colors = $request->input('colors', []);
                        $sizes = $request->input('sizes', []);
                        $quantities = $request->input('quantities', []);

                        foreach ($quantities as $index => $quantity) {
                            $this->productService->createWaitProductUnit([
                                'type' => $request->unittype,
                                'wait_product_id' => $product->id,
                                'color' => $colors[$index] ?? '',
                                'size' => $sizes[$index] ?? '',
                                'quantity' => $quantity > 0 ? $quantity : 1,
                            ]);
                        }
                    }

                    return redirect()->route('post.index')
                        ->with('success', 'Cập nhật thành công! Vui lòng chờ kiểm duyệt!');
                } else {
                    return redirect()->back()->with('error', 'Cập nhật thất bại.');
                }
            } else {
                $product = $this->productService->updateWaitProduct($request, $request->product_id);
                if ($product) {
                    $details = [];
                    if ($request->unittype == 1) {
                        $quantity = $request->quantity;
                        $details[] = [
                            'type' => $request->unittype,
                            'product_id' => $product->id,
                            'color' => null,
                            'size' => null,
                            'quantity' => $quantity > 0 ? $quantity : 1,
                        ];
                    } elseif ($request->unittype == 2) {
                        $colors = $request->input('colors', []);
                        $sizes = $request->input('sizes', []);
                        $quantities = $request->input('quantities', []);

                        foreach ($quantities as $index => $quantity) {
                            $details[] = [
                                'type' => $request->unittype,
                                'product_id' => $product->id,
                                'color' => $colors[$index] ?? '',
                                'size' => $sizes[$index] ?? '',
                                'quantity' => $quantity > 0 ? $quantity : 1,
                            ];
                        }
                    }
                    $this->productService->updateWaitProductUnit($details, $product->id);

                    return redirect()->route('post.index')
                        ->with('success', 'Cập nhật thành công! Vui lòng chờ kiểm duyệt!');
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi: '.$e->getMessage());
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

    public function status($id)
    {
        try {
            $product = Product::findOrFail($id);
            $this->statusService->pauseStatus($product);

            return response()->json(['success' => true, 'message' => 'Trạng thái đã được thay đổi.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra.'], 500);
        }
    }
}
