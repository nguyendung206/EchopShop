<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Imports\ProductImport;
use App\Jobs\CreateNotificationJob;
use App\Jobs\DeleteProductJob;
use App\Mail\ProductStatusMail;
use App\Mail\UpdateProductMail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\WaitProduct;
use App\Services\NotificationService;
use App\Services\ProductService;
use App\Services\StatusService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

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
        if (isset($request->is_export)) {
            flash('Xuất file thành công!')->success();

            return Excel::download(new ProductExport($datas), 'product.xlsx');
        }

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

                flash('Thêm mới sản phẩm thành công!')->success();

                return redirect()->route('admin.product.index');
            } else {
                flash('Không thể tạo sản phẩm, vui lòng thử lại.')->error();

                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Log::error('Error rejecting product update:', [
                'error' => $e->getMessage(),
                'product_id' => $request->id,
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);
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
                $this->productService->updateProductUnit($details, $id);

                flash('Cập nhật sản phẩm thành công!')->success();

                return redirect()->route('admin.product.index');
            } else {
                flash('Không thể cập nhật sản phẩm, vui lòng thử lại.')->error();

                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Log::error('Error deleting product: '.$e->getMessage());
            flash('Đã xảy ra lỗi, vui lòng thử lại.')->error();

            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->productService->deleteProduct($id);
            if ($result) {
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

            Mail::to($product->shop->email)
                ->later(now()->addMinute(), new ProductStatusMail($product, $title, $body, $isActive));

            Mail::to($product->shop->user->email)
                ->later(now()->addMinute(), new ProductStatusMail($product, $title, $body, $isActive));

            CreateNotificationJob::dispatch([
                'user_id' => $product->shop->user->id,
                'type' => $type,
                'title' => $title,
                'body' => $body,
                'product_id' => $product->id,
            ])->delay(now()->addMinute());

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

    public function wait(Request $request)
    {
        $datas = $this->productService->getWaitProducts($request->all());

        return view('admin.waitproduct.index', compact('datas'));
    }

    public function waitshow($id)
    {
        $product = Product::where('id', $id)->first();
        $wait = WaitProduct::where('product_id', $id)->first();

        return view('admin.waitproduct.show', compact('product', 'wait'));
    }

    public function reject(Request $request)
    {
        try {
            $product = WaitProduct::findOrFail($request->id);
            $title = 'Sản phẩm đã bị từ chối cập nhật';
            $body = 'Sản phẩm "'.$product->name.'" đã bị từ chối cập nhật.';
            $type = 3;

            Mail::to($product->shop->email)
                ->later(now()->addSeconds(2), new UpdateProductMail($product, $title, $body, $type));

            Mail::to($product->shop->user->email)
                ->later(now()->addSeconds(2), new UpdateProductMail($product, $title, $body, $type));

            CreateNotificationJob::dispatch([
                'user_id' => $product->shop->user->id,
                'type' => $type,
                'title' => $title,
                'body' => $body,
                'product_id' => $product->product_id,
            ])->delay(now()->addSeconds(2));

            DeleteProductJob::dispatch($product)->delay(now()->addSeconds(10));

            flash('Thay đổi trạng thái thành công')->success();
        } catch (\Exception $e) {
            Log::error('Error rejecting product update:', [
                'error' => $e->getMessage(),
                'product_id' => $request->id,
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);
            flash('Đã có lỗi xảy ra khi thay đổi trạng thái')->error();

            return redirect()->route('admin.wait.index');
        }

        return redirect()->route('admin.wait.index');
    }

    public function accept(Request $request)
    {
        try {
            $product = Product::findOrFail($request->product_id);
            $waitProduct = WaitProduct::findOrFail($request->id);

            $this->productService->updateUserProduct($request);

            $title = 'Sản phẩm đã được cập nhật';
            $body = 'Sản phẩm "'.$product->name.'" đã được cập nhật.';
            $type = 4;
            Mail::to($product->shop->email)
                ->later(now()->addSeconds(2), new UpdateProductMail($product, $title, $body, $type));

            Mail::to($product->shop->user->email)
                ->later(now()->addSeconds(2), new UpdateProductMail($product, $title, $body, $type));

            CreateNotificationJob::dispatch([
                'user_id' => $product->shop->user->id,
                'type' => $type,
                'title' => $title,
                'body' => $body,
                'product_id' => $request->product_id,
            ])->delay(now()->addSeconds(2));

            DeleteProductJob::dispatch($waitProduct)->delay(now()->addSeconds(10));

            flash('Thay đổi trạng thái thành công')->success();
        } catch (\Exception $e) {
            Log::error('Error rejecting product update:', [
                'error' => $e->getMessage(),
                'product_id' => $request->id,
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);
            flash('Đã có lỗi xảy ra khi thay đổi trạng thái')->error();

            return redirect()->route('admin.wait.index');
        }

        return redirect()->route('admin.wait.index');
    }

    public function import(Request $request)
    {
        try {
            $file = $request->file('fileImport');
            $data = Excel::toArray(new ProductImport, $file);
            if (empty($data) || count($data[0]) == 0) {
                flash('Tải file lên thất bại!')->error();

                return redirect()->back()->withErrors([
                    'data' => 'File rỗng không thể import dữ liệu',
                ]);
            }
            $rows = $data[0];
            $previewData = array_slice($rows, 0, 1);
            if (
                ! isset($previewData[0]['ten']) && ! isset($previewData[0]['gia']) &&
                ! isset($previewData[0]['hinh_thuc']) && ! isset($previewData[0]['anh_dai_dien']) &&
                ! isset($previewData[0]['danh_sach_anh']) && ! isset($previewData[0]['trang_thai']) &&
                ! isset($previewData[0]['mo_ta']) && ! isset($previewData[0]['chat_luong']) &&
                ! isset($previewData[0]['ten_shop']) && ! isset($previewData[0]['ten_thuong_hieu']) &&
                ! isset($previewData[0]['ten_danh_muc']) && ! isset($previewData[0]['kieu_chi_tiet']) &&
                ! isset($previewData[0]['mau']) && ! isset($previewData[0]['size']) && ! isset($previewData[0]['so_luong'])
            ) {
                flash('Tải file lên thất bại!')->error();

                return redirect()->back()->withErrors([
                    'header' => 'Dòng đầu tiên trong file phải là tên của các cột: ten, gia, hinh_thuc, anh_dai_dien, danh_sach_anh, trang_thai, mo_ta, chat_luong, ten_shop, ten_thuong_hieu, ten_danh_muc, kieu_chi_tiet, mau, size, so_luong',
                ]);
            }

            $file = $request->file('fileImport');
            Excel::import(new ProductImport, $file);

            flash('Tải file lên thành công!')->success();

            return redirect()->back();
        } catch (ValidationException $e) {
            flash('Tải file lên thất bại!')->error();
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                $row = $failure->row();
                foreach ($failure->errors() as $error) {
                    $messages[] = "Có lỗi ở dòng {$row}. {$error}";
                }
            }

            return redirect()->back()->withErrors($messages);
        }
    }
}
