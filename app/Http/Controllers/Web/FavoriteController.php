<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\FavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $result = $this->favoriteService->store($request);
        if ($result) {
            flash('Thêm yêu thích thành công')->success();

            return response()->json([
                'status' => 'success',
                'message' => 'Thêm yêu thích thành công',
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Đã có lỗi xảy ra',
        ], 500);

    }

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->favoriteService->destroy($id);
        if ($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'Xoá yêu thích thành công',
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Đã có lỗi xảy ra',
        ], 500);
    }
}
