<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Services\ContactService;

class ContactController extends Controller
{
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function create()
    {
        return view('web.about.contactUs');
    }

    public function store(ContactRequest $request)
    {
        try {
            $this->contactService->store($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'gửi thành công',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'gửi thất bại',
            ], 500);

        }
    }
}
