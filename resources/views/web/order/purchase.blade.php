@extends('web.layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('/css/product.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/product-detail.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/cart.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/pay.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/purchase.css') }}" />
@endsection
@section('title')
    PURCHASAE
@endsection
@section('content')
@php
    $type = request()->query('type');
@endphp
<div class="content">
    <div class=" container content-purchase">
        <div class="row purchase-title button-page-wrap">
            <a class='col-14 purchase-title-item {{empty($type) ? 'active' : '' }}' href="{{route("purchase")}}">Tất cả</a>
            <a class='col-14 purchase-title-item {{!empty($type) && $type == StatusOrderEnums::PENDING->value ? 'active' : '' }}' href="{{route("purchase", ['type' => StatusOrderEnums::PENDING])}}">Chờ thanh toán</a>
            <a class='col-14 purchase-title-item {{!empty($type) && $type == StatusOrderEnums::TRANSPORTING->value ? 'active' : '' }}' href="{{route("purchase", ['type' => StatusOrderEnums::TRANSPORTING])}}">Vận chuyển</a>
            <a class='col-14 purchase-title-item {{!empty($type) && $type == StatusOrderEnums::SHIPPING->value ? 'active' : '' }}' href="{{route("purchase", ['type' => StatusOrderEnums::SHIPPING])}}">Chờ giao hàng</a>
            <a class='col-14 purchase-title-item {{!empty($type) && $type == StatusOrderEnums::COMPLETED->value ? 'active' : '' }}' href="{{route("purchase", ['type' => StatusOrderEnums::COMPLETED])}}">Hoàn thành</a>
            <a class='col-14 purchase-title-item {{!empty($type) && $type == StatusOrderEnums::CANCELLED->value ? 'active' : '' }}' href="{{route("purchase", ['type' => StatusOrderEnums::CANCELLED])}}">Đã huỷ</a>
            <a class='col-14 purchase-title-item {{!empty($type) && $type == StatusOrderEnums::RETURN->value ? 'active' : '' }}' href="{{route("purchase", ['type' => StatusOrderEnums::RETURN])}}">Trả hàng</a>
        </div>

        <div class=" purchase-wrap ">
            @forelse ($orders as $order)
            <div class="purchase-order">
                @foreach ($order->orderDetails as $orderDetail)
                    @php
                        $product = $orderDetail->product;
                    @endphp
                    <div class="purchase-item py-2 row">
                        <div class="col-9 d-flex">
                            <div class="purchase-image">
                                <img src="{{getImage($product->photo)}}" alt="">
                            </div>
                            <div class="purchase-content">
                                <div class="purchase-name">{{$product->name}}</div>
                                <div class="purchase-type">Phân loại</div>
                                <div class="purchase-quatity">x{{$orderDetail->quantity}}</div>
                            </div>
                        </div>
                        <div class="col-3 d-flex align-items-center justify-content-end">
                            {{format_price($orderDetail->quantity * $product->price)}}
                        </div>
                    </div>                                                      
                @endforeach
                <div class="total-order row">
                    <div class="text-left col-6">
                        <p>Ngày tạo: {{date('d/m/Y', strtotime($order->created_at))}}</p>
                        <p style="color: #b10000" class="my-1">{{StatusOrderEnums::from($order->status->value)->label()}}</p>
                    </div>
                    @if ($order->discount)
                        
                    <div class="text-right total-price-purchase col-6">Thành tiền: <span class="init-money">{{format_price($order->total_amount)}}</span> <span class="discount-money">{{format_price(calculateDiscountedPrice($order->discount->type->value, $order->total_amount, $order->discount->value, $order->discount->max_value))}}</span></div>
                    @else
                    <div class="text-right total-price-purchase col-6">Thành tiền: <span class="discount-money">{{format_price($order->total_amount)}}</span> </div>
                    @endif
                    <div></div>
                </div>
            </div>
                <hr/>
            @empty
                <div class="text-center mt-2">
                    <img src="{{asset('/img/image/noorder.png')}}" alt="">
                </div>
            @endforelse
        </div>
    </div>
</div>



@endsection