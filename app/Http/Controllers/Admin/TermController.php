<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TermRequest;
use App\Models\Term;
use App\Services\TermService;
use App\Services\StatusService;


class TermController extends Controller
{
    protected $termService;

    public function __construct(TermService $termService, StatusService $statusService)
    {
        $this->termService = $termService;
        $this->statusService = $statusService;
    }

    public function index(Request $request)
    {
        $terms = $this->termService->index($request);
        return view('admin.term.index',compact('terms'));
    }


    public function create()
    {
        return view('admin.term.create');
    }

    
    public function store(TermRequest $request)
    {
        try {
            $this->termService->store($request);
            flash('Thêm điều khoản thành công')->success();

            return redirect()->route('admin.term.index');
        } catch (Exception $e) {
            flash('Thêm điều khoản thất bại')->error();

            return redirect()->route('admin.term.create');
        }
    }
    
    public function edit($id)
    {
        $term = Term::findOrFail($id);
        return view('admin.term.edit', compact('term'));
    }

    
    public function update(TermRequest $request, $id)
    {
        try {
            $term = $this->termService->update($request, $id);
            flash('Cập nhật điều khoản thành công!')->success();

            return redirect()->route('admin.term.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi cập nhật điều khoản!')->error();

            return redirect()->back()->withInput();
        }
    }

    
    public function destroy($id)
    {
        try {
            $check = $this->termService->destroy($id);
            if ($check) {
                flash('Xóa điều khoản thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa điều khoản!')->error();
            }
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa điều khoản!')->error();
        }
    }

    public function changeStatus($id) {
        try {
            $term = Term::findOrFail($id);
            $this->statusService->changeStatus($term);
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
