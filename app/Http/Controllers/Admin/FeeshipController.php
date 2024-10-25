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

class FeeshipController extends Controller
{
    protected $feeshipService;

    public function __construct(FeeshipService $feeshipService)
    {
        $this->feeshipService = $feeshipService;
    }

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
                flash('Chi phí vận chuyển đã tồn tại!')->error();
            } else {
                $this->feeshipService->createFeeship($request);
                flash('Thêm mới chi phí vận chuyển thành công!')->success();
            }

            return redirect()->route('admin.feeship.show', $request->province_id);
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi thêm mới chi phí vận chuyển!')->error();

            return redirect()->back()->withInput();
        }
    }

    public function show($id)
    {
        $districts = District::where('province_id', $id)->paginate(10);

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

    public function update(Request $request)
    {
        $feeship = Feeship::findOrFail($request->id);
        if ($request->has('value')) {
            $feeship->feeship = $request->value;
        }

        $feeship->save();

        return response()->json(['message' => 'Cập nhật thành công!']);
    }

    public function destroy($id)
    {
        try {
            $result = $this->feeshipService->deleteFeeShip($id);
            if ($result) {
                flash('Xóa chi phí thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa chi phí!')->error();
            }
        } catch (ModelNotFoundException $e) {
            flash('Chi phí không tồn tại!')->error();
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa chi phí!')->error();
        }

        return redirect()->route('admin.feeship.index');
    }
}
