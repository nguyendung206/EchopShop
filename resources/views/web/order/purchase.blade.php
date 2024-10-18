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
        <div class=" purchase-title button-page-wrap ">
            <a class='col-14 purchase-title-item {{empty($type) ? 'active' : '' }}' href="{{route("purchase")}}">Tất cả</a>
            <a class='col-14 purchase-title-item {{!empty($type) && $type == StatusOrderEnums::PENDING->value ? 'active' : '' }}' href="{{route("purchase", ['type' => StatusOrderEnums::PENDING])}}">Chờ thanh toán </a>
            <a class='col-14 purchase-title-item {{!empty($type) && $type == StatusOrderEnums::TRANSPORTING->value ? 'active' : '' }}' href="{{route("purchase", ['type' => StatusOrderEnums::TRANSPORTING])}}">Vận chuyển </a>
            <a class='col-14 purchase-title-item {{!empty($type) && $type == StatusOrderEnums::SHIPPING->value ? 'active' : '' }}' href="{{route("purchase", ['type' => StatusOrderEnums::SHIPPING])}}">Chờ giao hàng</a>
            <a class='col-14 purchase-title-item {{!empty($type) && $type == StatusOrderEnums::COMPLETED->value ? 'active' : '' }}' href="{{route("purchase", ['type' => StatusOrderEnums::COMPLETED])}}">Hoàn thành </a>
            <a class='col-14 purchase-title-item {{!empty($type) && $type == StatusOrderEnums::CANCELLED->value ? 'active' : '' }}' href="{{route("purchase", ['type' => StatusOrderEnums::CANCELLED])}}">Đã huỷ </a>
            <a class='col-14 purchase-title-item {{!empty($type) && $type == StatusOrderEnums::RETURN->value ? 'active' : '' }}' href="{{route("purchase", ['type' => StatusOrderEnums::RETURN])}}">Trả hàng </a>
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
                                @if (!empty($orderDetail->productUnit) && $orderDetail->productUnit->type == TypeProductUnitEnums::FULL->value)
                                <div class="purchase-type">Phân loại: màu {{$orderDetail->productUnit->color}}, size {{$orderDetail->productUnit->size}}</div>
                                @endif
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
                        <p  class="my-1">{{$order->shipping_address}}</p>
                    </div>
                    @if ($order->discount)
                    <div class="text-right total-price-purchase col-6">Thành tiền: <span class="init-money">{{format_price($order->total_amount)}}</span> <span class="discount-money">{{format_price(calculateDiscountedPrice($order->discount->type->value, $order->total_amount, $order->discount->value, $order->discount->max_value))}}</span></div>
                    @else
                    <div class="text-right total-price-purchase col-6">Thành tiền: <span class="discount-money">{{format_price($order->total_amount)}}</span> </div>
                    @endif

                    @if($order->status->value == StatusOrderEnums::CANCELLED->value)
                    <div class="col-6"></div>
                    <div class="col-6 text-right">
<<<<<<< HEAD
                        <div>

                            <a href="{{route('restoreCart', $order->id)}}" data-orderid="{{$order->id}}" class="btn-purchase">Mua lại</a>
                            <button class="btn-cancel-reason btn-purchase-light" data-order-id="{{ $order->id }}">Xem chi tiết huỷ đơn</button>
                        </div>
                    </div>
                    <div class="my-4  text-right col-12">
                        <div class="cancel-reason-{{ $order->id }} text-right "  style="display: none;">
                            Lý do: <span>{{optional($order->cancel_reason)->label()}}</span>
                        </div>
                    </div>
                    @endif
                    

                    @if($order->status->value == StatusOrderEnums::PENDING->value)
                    <div class="col-6"></div>
                    <div class="col-6 text-right">
                        <div>
                            <button class=" btn-purchase-light btn-cancel-order" data-id="{{ $order->id }}">Huỷ đơn</button>
=======
                        <div class="btn-post" style="color: white">
                            <a href="#">Mua lại</a>
>>>>>>> main
                        </div>
                    </div>
                    @endif
                    <div></div>
                </div>
            </div>
                <hr/>
            @empty
                <div class="text-center mt-2">
                    <img src="{{asset('/img/image/noorder.png')}}" class=" empty-image" alt="">
                </div>
            @endforelse
        </div>
    </div>
</div>

<div class="cancel-layer" id="cancelLayer">
    <form action="{{route('order.cancelOrder')}}" method="POST" id="cancelOrder">
        @csrf
        <div class="cancel-modal row" id="cancelModal">
            <h6 class="col-12 mt-3 mb-4">Lý do huỷ đơn hàng</h6>

            @foreach(\App\Enums\CancelOrderReason::cases() as $reason)
                <div class="form-check  p-2 col-12 d-flex align-items-center">
                    <input class="mr-2" type="radio" name="cancel_reason" id="reason-{{$reason->value}}" value="{{$reason->value}}">
                    <label class="form-check-label mt-1" for="reason-{{ $reason->value }}">
                        {{ $reason->label() }}
                    </label>
                </div>
            @endforeach
            <label class="text-danger cancel-error col-12 my-2">Vui lòng chọn lý do</label>
            <input type="hidden" name="orderId" value="0" class="order-id">
            <input type="hidden" name="status" value="{{StatusOrderEnums::CANCELLED->value}}">
            <div class="col-12 text-right mt-4">
                <button class="cancel b-radius" id="cancelButton" type="button">Không phải bây giờ</button>
                <button class="buy b-radius" id="submitChangeAddress" type="submit">Huỷ đơn hàng</button>
            </div>
        </div>
    </form>
</div>

<div class="confirm-layer" id="confirmModal">
    <div class="confirm-modal">
        <h5>Khôi phục đơn hàng</h5>
        <p class="my-3">Mặt hàng có trong hoá đơn này sẽ được thêm lại vào giỏ</p>
        <div class="modal-restore-content">

        </div>
        <div class="col-12 text-right mt-4">
            <button id="confirmNo" class="cancel b-radius">Huỷ</button>
            <button id="confirmYes" class="buy b-radius" >Thêm vào giỏ</button>
        </div>
    </div>
</div>


@section('script')
<script>  
    function getImage(path = null) {
        const defaultImage = '/img/image/nodiscount.png';
        if (!path) {
            return defaultImage;
        }
        if (path.includes('upload')) {
            return `/storage/${path}`;
        }
        return `/img/image/${path}`;
    }
                
    var orders = @json($orders);
    $(document).ready(function() {
        $('.btn-cancel-order').on('click', function() {
            var orderId = $(this).data('id');
            $('.order-id').val(orderId);            
            $('#cancelLayer').fadeIn();
            $('.cancel-error').hide()
        });

        $('#cancelLayer').on('click', function(e) {
            if ($(e.target).is('#cancelLayer')) {
                $('#cancelLayer').fadeOut();
            }
        });

        $('#cancelButton').on('click', function() {
            $('#cancelLayer').fadeOut();
        });

        $('#submitChangeAddress').on('click', function(e) {
            if (!$('input[name="cancel_reason"]:checked').length) {
                e.preventDefault();
                $('.cancel-error').show();
            }
        });
    });

    $(document).ready(function() {
        $('.btn-purchase').on('click', function(e) {
            e.preventDefault();
            $('.modal-restore-content').empty();
            var url = $(this).attr('href');
            var orderId = $(this).data('orderid')
            var orderSelected = null;
            var orderDetailHtml = ''
            orders.forEach(order => {
                if(order.id == orderId) {
                    orderSelected = order;
                }
            });
            
            if (orderSelected !== null) {
                orderSelected.order_details.forEach(orderDetail => {
                var product = orderDetail.product;
                var productUnit = orderDetail.productUnit;
                orderDetailHtml += `
                    <div class="purchase-item py-2 row">
                        <div class="col-9 d-flex align-items-center">
                            <div class="purchase-image">
                                <img src="${getImage(product.photo)}" alt="">
                            </div>
                            <div class="purchase-content">
                                <div class="purchase-name">${product.name}</div>
                                <div class="purchase-name">Số lượng: ${orderDetail.quantity}</div>
                            </div>
                        </div>
                    </div>`;
                });
                $('.modal-restore-content').append(orderDetailHtml);
            }


            $('#confirmModal').fadeIn();
            $('#confirmYes').on('click', function() {
                $.ajax({
                    url: url,
                    method: 'GET', 
                    success: function(response) {
                        window.location.href = @json(route('cart.index'));
                    },
                });
                $('#confirmModal').fadeOut();
            });
            $('#confirmNo').on('click', function() {
                $('#confirmModal').fadeOut(); // Đóng modal
            });
        });

        $('.btn-cancel-reason').on('click', function() {
            var orderId = $(this).data('order-id');
            console.log(orderId);
            console.log($('.cancel-reason-' + orderId));
            $('.cancel-reason-' + orderId).slideToggle();
        });
    });


</script>


@endsection

@endsection