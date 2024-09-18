<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Models\Contact;
use App\Services\ContactService;
use App\Services\StatusService;
use Illuminate\Http\Request;
use Mail;

class ContactController extends Controller
{
    public function __construct(ContactService $contactService, StatusService $statusService)
    {
        $this->contactService = $contactService;
        $this->statusService = $statusService;
    }

    public function index(Request $request)
    {
        $contacts = $this->contactService->index($request);

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
            Mail::to($request->email)->send(new ContactMail($request->content, $request->contentUser));
            if ($request->status == Status::ACTIVE->value) {
                $contact = Contact::findOrFail($request->id);
                $contact->status = Status::INACTIVE;
                $contact->save();
            }
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

    public function changeStatus(Request $request, $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $this->statusService->changeStatus($contact);
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
