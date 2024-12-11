<?php

namespace App\Http\Controllers\Web;

use App\Enums\Status;
use App\Enums\TypeNotification;
use App\Enums\TypeProduct;
use App\Http\Controllers\Controller;
use App\Jobs\CreateNotificationJob;
use App\Mail\RequestExchangeMail;
use App\Models\Exchange;
use App\Models\Product;
use App\Services\ExchangeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ExchangeController extends Controller
{
    public function __construct(public readonly ExchangeService $exchangeService) {}

    public function index(Request $request)
    {
        try {
            $exchanges = $this->exchangeService->getList(10);

            if ($request->ajax()) {
                $exchangeHtml = view('web.exchange.moreExchange', compact('exchanges'))->render();
                $hasMorePage = $exchanges->hasMorePages();

                return response()->json([
                    'exchanges' => $exchangeHtml,
                    'hasMorePage' => $hasMorePage,
                ]);
            }

            return view('web.exchange.exchangeList', compact('exchanges'));
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi tải danh sách hàng trao đổi!')->error();

            return redirect()->back();
        }
    }

    public function show($id)
    {
        $exchange = Exchange::findOrFail($id);

        return view('web.exchange.exchangeDetail', compact('exchange'));
    }

    public function getUserExchangeProducts()
    {
        $products = Product::where('user_id', Auth::id())
            ->where('type', TypeProduct::EXCHANGE->value)
            ->where('status', Status::ACTIVE->value)
            ->get()
            ->map(function ($product) {
                $product->image_url = getImage($product->photo);

                return $product;
            });

        return response()->json($products);
    }

    public function store(Request $request)
    {
        try {
            $result = $this->exchangeService->store($request);

            $title = TypeNotification::REQUESTEXCHANGE->label();
            $body = 'Sản phẩm "'.$result->product->name.'" nhận được yêu cầu trao đổi.';

            Mail::to($result->receiver->email)
                ->later(now()->addSecond(), new RequestExchangeMail($result->exchangeProduct, $result->product, $title, $body));

            CreateNotificationJob::dispatch([
                'user_id' => $result->receiver_id,
                'type' => TypeNotification::REQUESTEXCHANGE->value,
                'title' => $title,
                'body' => $body,
                'product_id' => $result->product->id,
            ])->delay(now()->addSecond());

            return response()->json(['status' => 200, 'message' => 'Đã gửi yêu cầu đổi hàng thành công!', 'data' => $result]);
        } catch (\Exception $e) {
            Log::error('Error processing exchange: '.$e->getMessage());

            return response()->json(['status' => 500, 'message' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau.']);
        }
    }

    public function accept($id)
    {
        try {
            $exchange = Exchange::findOrFail($id);
            $this->exchangeService->accept($exchange);

            return redirect()->route('exchange.index')->with('success', 'Đơn hàng trao đổi đã được chấp nhận thành công.');
        } catch (\Exception $e) {
            Log::error('Error accepting exchange: '.$e->getMessage());

            return redirect()->route('exchange.index')->with('error', 'Có lỗi xảy ra khi chấp nhận đơn hàng.');
        }
    }

    public function reject($id)
    {
        try {
            $exchange = Exchange::findOrFail($id);
            $this->exchangeService->reject($exchange);

            return redirect()->route('exchange.index')->with('success', 'Đơn hàng trao đổi đã được từ chối thành công.');
        } catch (\Exception $e) {
            Log::error('Error rejecting exchange: '.$e->getMessage());

            return redirect()->route('exchange.index')->with('error', 'Có lỗi xảy ra khi từ chối đơn hàng.');
        }
    }
}
