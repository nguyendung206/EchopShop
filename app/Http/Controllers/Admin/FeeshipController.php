<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeeshipRequest;
use App\Models\District;
use App\Models\Feeship;
use App\Models\Province;
use App\Models\Ward;
use App\Services\FeeshipService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FeeshipController extends Controller
{
    public function __construct(public readonly FeeshipService $feeshipService) {}

    public function selectAddress(Request $request)
    {
        if ($request->has('action')) {
            if ($request->action == 'province') {
                $districts = District::where('province_id', $request->id)
                    ->orderBy('id', 'ASC')->get();

                return response()->json($districts);
            } elseif ($request->action == 'district') {
                $wards = Ward::where('district_id', $request->id)
                    ->orderBy('id', 'ASC')->get();

                return response()->json($wards);
            }
        }

        return response()->json(['error' => 'Invalid action'], 400);
    }

    public function index(Request $request)
    {
        try {
            $datas = $this->feeshipService->getFeeships($request);
            $provinces = Province::orderby('id', 'ASC')->get();

            return view('admin.feeship.index', compact('datas', 'provinces'));
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi tải danh sách chi phí vận chuyển!')->error();

            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $provinces = Province::orderby('id', 'ASC')->get();

            return view('admin.feeship.create', compact('provinces'));
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi tải danh sách Tỉnh/Thành phố!')->error();

            return redirect()->back();
        }
    }

    public function store(FeeshipRequest $request)
    {
        try {
            $feeship = Feeship::where('province_id', $request->province_id)
                ->where('district_id', $request->district_id)
                ->where('ward_id', $request->ward_id)
                ->first();

            if ($feeship) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chi phí vận chuyển đã tồn tại!',
                    'errors' => [
                        'district_id' => 'Chi phí đã tồn tại cho khu vực này.',
                    ],
                ], 400);
            }

            $this->feeshipService->createFeeship($request);

            return response()->json(['success' => true, 'message' => 'Thêm mới chi phí vận chuyển thành công!']);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi thêm mới chi phí vận chuyển!',
                'errors' => [
                    'district_id' => 'Có lỗi xảy ra. Vui lòng thử lại.',
                ],
            ], 500);
        }
    }

    public function show($id)
    {
        $districts = District::where('province_id', $id)->get();

        return view('admin.feeship.show', compact('districts'));
    }

    public function getWards(Request $request)
    {
        $districtId = $request->input('district_id');
        $feeships = Feeship::where('district_id', $districtId)->get()->keyBy('ward_id');
        $wards = Ward::where('district_id', $districtId)->get();

        return response()->json([
            'wards' => $wards,
            'feeships' => $feeships,
        ]);
    }

    public function update(FeeshipRequest $request, $id)
    {
        try {
            $feeship = $this->feeshipService->updateFeeship($request, $id);
            $districtName = $feeship->district->district_name;

            return response()->json([
                'message' => 'Cập nhật thành công!',
                'feeship' => $feeship,
                'districtName' => $districtName,
            ]);
        } catch (\Exception $e) {
            Log::error('Cập nhật phí vận chuyển thất bại: '.$e->getMessage());

            return response()->json([
                'message' => 'Đã có lỗi xảy ra!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $feeship = Feeship::findOrFail($id);
            $districtName = $feeship->district->district_name;
            $districtId = $feeship->district_id;
            $result = $this->feeshipService->deleteFeeship($id);
            if ($result) {
                return response()->json([
                    'message' => 'Xóa chi phí thành công!',
                    'districtId' => $districtId,
                    'districtName' => $districtName,
                ]);
            } else {
                return response()->json(['message' => 'Đã xảy ra lỗi khi xóa chi phí!'], 500);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Chi phí không tồn tại!'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi khi xóa chi phí!'], 500);
        }
    }
}
