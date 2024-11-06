<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TypeNotification;
use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Imports\OrderImport;
use App\Services\NotificationService;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class OrderController extends Controller
{
    protected $orderService;

    protected $notificationService;

    public function __construct(OrderService $orderService, NotificationService $notificationService)
    {
        $this->orderService = $orderService;
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $orders = $this->orderService->index($request->all());

        if (isset($request->is_export)) {
            flash('Xuất file thành công!')->success();

            return Excel::download(new OrderExport($orders), 'order.xlsx');
        }

        return view('admin.order.index', compact('orders'));
    }

    public function create(Request $request)
    {
        try {

            $datas = $this->orderService->create();

            return view('admin.order.create', ['products' => $datas['products'], 'customers' => $datas['customers']]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $order = $this->orderService->storeCMS($request->all());
            flash('Thêm đơn hàng thành công')->success();

            return redirect()->route('admin.order.index');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id)
    {
        try {
            $order = $this->orderService->getOrderById($id);

            return view('admin.order.show', compact('order'));
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $order = $this->orderService->updateStatus($request->all(), $id);
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at, 'UTC')->setTimezone('Asia/Bangkok')->format('d-m-Y H:i:s');
            $title = 'Đơn hàng đã được cập nhật';
            $body = 'Đơn hàng của quý khách '.$order->customer->name.' đặt lúc '.$date.' đã chuyển thành "'.$order->status->label().'".Vui lòng kiểm tra email của bạn để biết thêm chi tiết.';
            $this->notificationService->createNotification([
                'user_id' => $order->user_id,
                'type' => TypeNotification::CHANGESTATUSORDER,
                'title' => $title,
                'body' => $body,
            ]);
            flash('Thay đổi trạng thái thành công!')->success();

            return redirect()->back();
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function import(Request $request)
    {
        try {
            $file = $request->file('fileImport');
            $data = Excel::toArray(new OrderImport, $file);
            if (empty($data) || count($data[0]) == 0) {
                flash('Tải file lên thất bại!')->error();

                return redirect()->back()->withErrors([
                    'data' => 'File rỗng không thể import dữ liệu',
                ]);
            }
            $rows = $data[0];
            $previewData = array_slice($rows, 0, 1);
            if (! array_key_exists('ten_khach_hang', $previewData[0]) || ! array_key_exists('dia_chi_nhan_hang', $previewData[0]) || ! array_key_exists('phuong_xa', $previewData[0]) || ! array_key_exists('quan_huyen', $previewData[0]) || ! array_key_exists('tinh_thanh', $previewData[0]) || ! array_key_exists('tien_goc', $previewData[0]) || ! array_key_exists('ma_giam_gia', $previewData[0]) || ! array_key_exists('trang_thai', $previewData[0]) || ! array_key_exists('ten_san_pham', $previewData[0]) || ! array_key_exists('so_luong', $previewData[0]) || ! array_key_exists('gia', $previewData[0]) || ! array_key_exists('mau', $previewData[0]) || ! array_key_exists('kich_co', $previewData[0])) {
                flash('Tải file lên thất bại!')->error();

                return redirect()->back()->withErrors([
                    'header' => 'Dòng đầu tiên trong file phải là tên của các cột: Tên khách hàng, địa chỉ nhận hàng, phường xã, quận huyện, tỉnh thành, tiền gốc, mã giảm giá, thành tiền, trạng thái. Lưu ý không bỏ trống dữ liệu',
                ]);
            }

            $file = $request->file('fileImport');
            Excel::import(new OrderImport, $file);

            flash('Tải file lên thành công!')->success();

            return redirect()->back();
        } catch (ValidationException $e) {
            flash('Tải file lên thất bại!')->error();
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                $row = $failure->row();
                foreach ($failure->errors() as $error) {
                    $messages[] = "Có lỗi ở dòng {$row}. {$error}";
                }
            }

            return redirect()->back()->withErrors($messages);
        }
    }
}
