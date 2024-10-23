<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\FeeshipService;
use Exception;
use Illuminate\Http\Request;

class FeeshipController extends Controller
{
    protected $feeshipService;

    public function __construct(FeeshipService $feeshipService)
    {
        $this->feeshipService = $feeshipService;
    }

    public function index(Request $request)
    {
        try {
            $datas = $this->feeshipService->getFeeships($request);

            return view('admin.feeship.index', compact('datas'));
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi tải danh sách chi phí vận chuyển!')->error();

            return redirect()->back();
        }
    }
}
