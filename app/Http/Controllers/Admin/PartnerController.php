<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Services\PartnerService;
use Illuminate\Http\Request;
use App\Http\Requests\PartnerRequest;

class PartnerController extends Controller
{
    
    protected $partnerService;

    public function __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;
    }

    public function index()
    {   
        $partners = Partner::query()->paginate(5);
        return view('admin.Partner.index', compact('partners'));
    }

    
    public function create()
    {
        return view('admin.Partner.create');
    }

   
    public function store(PartnerRequest $request)
    {
        try {
            $this->partnerService->store($request);
            flash('Thêm partner thành công')->success();

            return redirect()->route('partner.index');
        } catch (Exception $e) {
            flash('Thêm partner thất bại')->error();

            return redirect()->route('partner.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        if (! $partner) {
            return back()->with('message', 'Không có đối tác tương ứng');
        }

        return view('admin.partner.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PartnerRequest $request, $id)
    {
        try {
            $partner = $this->partnerService->update($request, $id);
            flash('Cập nhật đối tác thành công!')->success();

            return redirect()->route('partner.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi cập nhật đối tác!')->error();

            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $check = $this->partnerService->destroy($id);
            if ($check) {
                flash('Xóa đối tác thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa đối tác!')->error();
            }
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa đối tác!')->error();
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $partner = Partner::find($id);
        if (! $partner) {
            flash('Sửa thông tin thất bại')->error();

            return back();
        }
        try {
            $updateData = [
                'status' => $request->status,
            ];
            $partner->update($updateData);

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
