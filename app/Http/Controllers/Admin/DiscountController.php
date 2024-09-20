<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
use App\Models\Discount;
use App\Services\DiscountService;
use App\Services\StatusService;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    protected $discountService;

    protected $statusService;

    public function __construct(DiscountService $discountService, StatusService $statusService)
    {
        $this->discountService = $discountService;
        $this->statusService = $statusService;
    }

    public function index(Request $request)
    {
        $discounts = $this->discountService->index($request);

        return view('admin.discount.index', compact('discounts'));

    }

    public function create()
    {
        return view('admin.discount.create');
    }

    public function store(DiscountRequest $request)
    {
        try {
            $this->discountService->store($request);
            flash('Thêm giảm giá thành công')->success();

            return redirect()->route('admin.discount.index');
        } catch (Exception $e) {
            flash('Thêm giảm giá thất bại')->error();

            return redirect()->route('admin.discount.create');
        }
    }

    public function show($id)
    {
        $discount = Discount::findOrFail($id);

        return view('admin.discount.show', compact('discount'));
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);

        return view('admin.discount.edit', compact('discount'));
    }

    public function update(DiscountRequest $request, $id)
    {
        try {
            $discount = $this->discountService->update($request, $id);
            flash('Cập nhật giảm giá thành công!')->success();

            return redirect()->route('admin.discount.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi cập nhật giảm giá!')->error();

            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $check = $this->discountService->destroy($id);
            if ($check) {
                flash('Xóa giảm giá thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa giảm giá!')->error();
            }
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa giảm giá!')->error();
        }
    }

    public function changeStatus(Request $request, $id)
    {
        try {
            $discount = Discount::findOrFail($id);
            $this->statusService->changeStatus($discount);
            flash('Thay đổi trạng thái thành công!')->success();

            return response()->json([
                'status' => 'success',
                'message' => 'Sửa thông tin thành công.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sửa thông tin thất bại.',
            ], 500);
        }
    }
}