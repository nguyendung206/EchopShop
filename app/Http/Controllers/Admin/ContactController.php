<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Jobs\SendContactMail;
use App\Models\Contact;
use App\Services\ContactService;
use App\Services\StatusService;
use Exception;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(ContactService $contactService, StatusService $statusService)
    {
        $this->contactService = $contactService;
        $this->statusService = $statusService;
    }

    public function index(Request $request)
    {
        $contacts = $this->contactService->index($request->all());

        return view('admin.contact.index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        return view('admin.contact.show', compact('contact'));
    }

    public function sendMail(ContactRequest $request)
    {
        try {
            $emailJob = new SendContactMail($request->content, $request->contentUser, $request->email);
            dispatch($emailJob);
            flash('Đã gửi tin nhắn đến mail của người dùng')->success();

            return back();
        } catch (\Throwable $th) {
            flash('Đã có lỗi xảy ra vui lòng thử lại');

            return back();
        }

    }

    public function destroy($id)
    {
        try {
            $check = $this->contactService->destroy($id);
            if ($check) {
                flash('Xóa Banner thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa Banner!')->error();
            }
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa Banner!')->error();
        }
    }
}
