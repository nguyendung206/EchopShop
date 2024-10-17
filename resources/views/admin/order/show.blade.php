@extends('admin.layout.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Thông tin đơn hàng')}}</h5>
    </div>
    <form action="{{route('admin.order.updateStatus', $order->id)}}" method="POST">
        @csrf
    <div class="card">
        <section class="" style="background-color: #f4f5f7;">
            <div class="  h-100">
            <div class="row d-flex justify-content-center pt-5 h-100">
                <div class="col col-lg-6 mb-4 mb-lg-0">
                <div class="card mb-3" style="border-radius: .5rem;">
                    <div class="row g-0">
                        <div class="col-md-12 gradient-custom text-center text-white"
                        style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                        
                        </div>
                    </div>
                    <div class="row g-0">
                    
                    <div class="col-md-12">
                        <div class="card-body p-4">
                        <h6>
                            Quý khách:   {{$order->customer->name}}
                        </h6>
                        <hr class="mt-0 mb-4">
                        <div class="row pt-1">
                            <div class="col-6 mb-3">
                            <h6>Địa chỉ nhận hàng</h6>
                            <p class="text-muted">{{strip_tags($order->shipping_address)}}</p>
                            </div>
                            <div class="col-6 mb-3">
                            <h6>Phương thức thanh toán</h6>
                            <p class="text-muted">{{$order->type_payment->label()}}</p>
                            </div>
                        </div>

                        <div class="row pt-1">
                            <div class="col-6 mb-3">
                            <h6>Tiền gốc</h6>
                            <p class="text-muted">{{format_price($order->total_amount)}}</p>
                            </div>
                            <div class="col-6 mb-3">
                            <h6>Giảm giá</h6>
                            <p class="text-muted">{{!empty($order->discount) ? format_price(calculateDiscountAmount($order->discount->type->value, $order->total_amount, $order->discount->value, $order->discount->max_value)) : 'Không giảm giá'}}</p>
                            </div>

                            <div class="col-6 mb-3">
                                <h6>Thành tiền</h6>
                                <p class="text-muted">{{!empty($order->discount) ? format_price(calculateDiscountedPrice($order->discount->type->value, $order->total_amount, $order->discount->value, $order->discount->max_value)) : format_price($order->total_amount)}}</p>
                            </div>

                            <div class="col-6 mb-3">
                                <h6>Ngày tạo</h6>
                                <p class="text-muted">{{$order->created_at}}</p>
                            </div>
                        </div>

                        <div class="row pt-1">
                            <div class="col-6 mb-3">
                                <h6>Trạng thái</h6>
                                @if ($order->status->value != StatusOrderEnums::COMPLETED->value && $order->status->value != StatusOrderEnums::CANCELLED->value && $order->status->value != StatusOrderEnums::RETURN->value)
                                    <select class=" aiz-selectpicker  font-weight-500 w-100"
                                    id="status" name="status">
                                    <option value="" disabled>Trạng thái</option>
                                    @if ($order->status->value == StatusOrderEnums::PENDING->value)
                                        @foreach (StatusOrderEnums::cases() as $statusOrder)
                                        @if (StatusOrderEnums::PENDING->value == $statusOrder->value || StatusOrderEnums::TRANSPORTING->value == $statusOrder->value || StatusOrderEnums::CANCELLED->value ==  $statusOrder->value || StatusOrderEnums::RETURN->value ==  $statusOrder->value)
                                        <option value="{{ $statusOrder->value }}" 
                                            @if ($order->status->value == $statusOrder->value) selected @endif>
                                            {{ $statusOrder->label() }}
                                        </option>
                                        @endif
                                        @endforeach

                                    @elseif($order->status->value == StatusOrderEnums::TRANSPORTING->value)
                                        
                                        <option value="{{ StatusOrderEnums::TRANSPORTING->value }}" @if ($order->status->value == StatusOrderEnums::SHIPPING->value) selected @endif>
                                            {{ StatusOrderEnums::TRANSPORTING->label() }}
                                        </option>

                                        <option value="{{ StatusOrderEnums::SHIPPING->value }}" 
                                            @if ($order->status->value == StatusOrderEnums::SHIPPING->value) selected @endif>
                                            {{ StatusOrderEnums::SHIPPING->label() }}
                                        </option>
                                    
                                    @elseif($order->status->value == StatusOrderEnums::SHIPPING->value)
                                        <option value="{{ StatusOrderEnums::SHIPPING->value }}" @if ($order->status->value == StatusOrderEnums::SHIPPING->value) selected @endif>
                                            {{ StatusOrderEnums::SHIPPING->label() }}
                                        </option>

                                        <option value="{{ StatusOrderEnums::COMPLETED->value }}" 
                                            @if ($order->status->value == StatusOrderEnums::COMPLETED->value) selected @endif>
                                            {{ StatusOrderEnums::COMPLETED->label() }}
                                        </option>
                                    @endif

                                </select>

                                @else
                                    <p class="text-muted">{{$order->status->label()}}</p>
                                @endif
                            </div>
                            
                        </div>

                       

                        <div class="row pt-1">
                            <div class="col-12 mb-3">
                                <h6>Đơn hàng</h6>
                                <table class="table">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tên sản phẩm</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Thông tin</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderDetails as $index => $orderDetail)
                                            <tr>
                                                <th scope="row">{{$index + 1}}</th>
                                                <td>{{$orderDetail->product->name}}</td>
                                                <td>{{$orderDetail->quantity}}</td>
                                                <td>{{format_price($orderDetail->product->price)}}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('web.productdetail.index', ['slug' => $orderDetail->product->slug]) }}" class="btn btn-info" style="color: white;font-size:10px;padding:4px 8px"><i class="fa-solid fa-bars"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                      
                                    </tbody>
                                  </table>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a class="btn btn-secondary" style="color: white" href="{{route("admin.order.index")}}">Trở về</a>
                            @if ($order->status->value == StatusOrderEnums::PENDING->value || $order->status->value == StatusOrderEnums::TRANSPORTING->value || $order->status->value == StatusOrderEnums::SHIPPING->value)
                                <button class="btn btn-primary" style="color: white"  type="submit">Xác nhận</button>
                            @elseif ($order->status->value == StatusOrderEnums::COMPLETED->value)
                                <p style="font-size: 0.875rem;padding: 0.6rem 1.2rem; margin-bottom: 0px" class="text-success">Đã hoàn thành</p>
                            @elseif ($order->status->value == StatusOrderEnums::CANCELLED->value)
                                <p style="font-size: 0.875rem;padding: 0.6rem 1.2rem; margin-bottom: 0px" class="text-danger">Đã huỷ đơn</p>
                            @elseif ($order->status->value == StatusOrderEnums::RETURN->value)
                                <p style="font-size: 0.875rem;padding: 0.6rem 1.2rem; margin-bottom: 0px" class="text-warning">Đã trả đơn/hoàn tiền</p>
                            @endif
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </section>
    </div>
    </form>
</div>
@endsection

