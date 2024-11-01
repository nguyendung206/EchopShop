@extends('web.layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('/css/product.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/product-detail.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/cart.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/pay.css') }}" />
@endsection
@section('title')
    ORDER
@endsection
@section('content')
    @php
        $user = Auth::user();
        $sum = 0;
        $voucherSelected = collect();
        $defaultAddress = $user->defaultAddress;
    @endphp
    <div class="content-address">
        <div class="address-wrap container px-0">
            <div class="border-pay"></div>
            <div class="content-address-main">
                <div class="location-address"><i class="fa-solid fa-location-dot"></i> Địa chỉ nhận hàng</div>
                <div class="information-receive">
                    @if ($user->defaultAddress == null)
                        <span class="infor-address">Vui lòng thêm địa chỉ của bạn <a href="{{route("profile.address")}}">Tại đây</a></span>
                    @else
                        <span class="infor-address">
                        <b class="mr-3">
                        {{ $defaultAddress->user_name }} (+84) {{ $defaultAddress->phone }}</b>
                        {{ $defaultAddress->street }}, {{ $defaultAddress->ward->ward_name }}, {{ $defaultAddress->district->district_name }},
                        {{ $defaultAddress->province->province_name }}</span>
                        <button class="change-address p-1 b-radius" id="btnChangeAddress">Thay đổi</button>
                    @endif

                </div>
                
            </div>
        </div>
    </div>

    <form action="{{route('order.payOrder')}}" method="POST" style="background-color: #f5f5f5;">
        @csrf
        
        <div class="content-items">
            <div class="content-wrap container">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Số tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        @foreach ($orderCarts as $cart)
                            @php
                                $sum += $cart->products->price * $cart->quantity;
                                $totalPay = $sum + ($feeship->feeship ?? 0);
                            @endphp
                            <tr class="text-center">
                                <td class="align-middle">
                                    <div class="infor-cart">
                                        <div class="img-item">
                                            <img src="{{ getImage($cart->products->photo) }}"
                                                alt="{{ $cart->products->name }}" />
                                        </div>
                                        <div class="item-details ml-3">
                                            <div class="name-item-cart mb-2">
                                                {{ $cart->products->name }}
                                            </div>
                                            <div class="item-meta mb-2">
                                                <p>{!! $cart->products->description !!}</p>
                                            </div>

                                            <div class="type-show">
                                                @if (! empty($cart->products->getProductUnitById($cart->product_unit_id)->size) && ! empty($cart->products->getProductUnitById($cart->product_unit_id)->color))
                                                <p>Phân loại hàng:</p>
                                                <div class="type-size-{{$cart->id}}"> &nbsp; size {{$cart->products->getProductUnitById($cart->product_unit_id)->size}}, </div>
                                                <div class="type-color-{{$cart->id}}">&nbsp; màu {{$cart->products->getProductUnitById($cart->product_unit_id)->color}}. </div>
                                                @endif
    
                                            </div>
                                        </div>
                                        
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="original-price">{{ format_price($cart->products->price) }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="number-input">
                                        {{ $cart->quantity }}
                                    </div>
                                </td>
                                <td class="total-amount align-middle">
                                    {{ format_price($cart->products->price * $cart->quantity) }}</td>
                                
                        </tr>
                        <tr>
                            <td colspan="5">
                            <div class="content-pay">
                                <div class="message-to-shop col-lg-5">
                                    <p>Lời nhắn</p>
                                    <textarea name="message-{{$cart->id}}"></textarea>
                                </div>
                                <div class="infor-to-pay col-lg-7">
                                    {{-- <div class="unit-shipper col-lg-12">
                                        <div class="name-shipper col-lg-3">Đơn vị vận chuyển</div>
                                        <div class="infor-shipper col-lg-9">
                                            <div class="unit-shipper-1">
                                                Nhanh <button>Thay đổi</button> đ 50.100
                                            </div>
                                            <div class="unit-shipper-2">
                                                <div class="unit-shipper-2-1">
                                                    Đảm bảo nhận hàng từ 17 tháng 8 - 20 tháng 8
                                                </div>
                                                <div class="unit-shipper-2-2">Nhận bồi thường nếu đơn hàng được bàn giao sau ngày 20 tháng
                                                    8</div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="total-last col-lg-12">Tổng số tiền(<span
                                            style="color: #B10000">{{ $orderCarts->count() }}</span>): <b>{{ format_price($sum) }}</b></div>
                                </div>
                            </div>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                
            </div>
        </div>

        <div class="content-pay-method">
            <div class="pay-method-wrap container">
                <div class="pay-method-title">
                    Phương thức thanh toán
                </div>
                <div class="row align-items-center">
                    <div class="voucher col-lg-5 col-12 text-center" id="voucherShow">
                        <button id="btnVoucher" class="btn-show-voucher b-radius" type="button">Chọn
                            Voucher</button>
                        <div class="voucher-layer" id="voucherLayer">
                            <div class="voucher-modal" id="voucherModal">
                                <p class="voucher-title">Áp mã để giảm giá</p>
                                <div class="voucher-code">
                                    <p class="col-3 code-title">Mã Voucher</p>
                                    <div class="col-9 code-input">
                                        <input type="text" id="voucherCode">
                                        <p class="btn-show-voucher b-radius submitVoucher btn-apply-voucher line-clamp-1" data-voucher="code" type="button">Áp dụng</p>
                                    </div>
                                    
                                </div>
                                <div id="errorCode">
                                </div>
                                <div class="voucher-list row">
                                    @forelse ($vouchers as $voucher)
                                        <div class="voucher-item col-12">
                                            <div class="voucher-image col-3">
                                                <img src="{{ getImage($voucher->photo) }}" alt="voucher">
                                            </div>
                                            <div class="voucher-content col-6">
                                                <p>Tiêu đề: {{$voucher->title}}</p>
                                                <p>Giảm: {{ $voucher->type == TypeDiscountEnums::PERCENT ? $voucher->value. ' %' : format_price($voucher->value)}}</p>
                                                @if ($voucher->type == TypeDiscountEnums::PERCENT)
                                                    <p>Giảm tối đa: {{format_price($voucher->max_value)}}</p>
                                                @endif
                                                    @php
                                                        $userUsedArray = explode(',', $voucher->user_used);
                                                        $userId = Auth::id();
                                                        $numberUsed = count(array_filter($userUsedArray, function($id) use ($userId) {
                                                                                return $id == $userId;
                                                                            }));
                                                    @endphp
                                                <p>Số lần dùng: {{ $numberUsed .' /'. $voucher->limit_uses}}</p>
                                                <p>Còn lại: {{$voucher->max_uses - $voucher->quantity_used}}</p>
                                                <p>Hết hạn sau: {{dateRemaining($voucher->end_time)}}</p>
                                                @if ($voucher->scope_type->value == TypeDiscountScopeEnums::REGIONAL->value)
                                                    <p class="mt-1 text-left">Chỉ cho khu vực: 
                                                        {{optional($voucher->ward)->ward_name}}
                                                        @if(optional($voucher->ward)->ward_name) , @endif
                                                        {{optional($voucher->district)->district_name}}
                                                        @if(optional($voucher->district)->district_name) , @endif
                                                        {{optional($voucher->province)->province_name}}.</p>
                                                @endif
                                            </div>
                                            <div class="voucher-button col-3">
                                                @if ($voucher->limit_uses == $numberUsed)
                                                    <p style="color: #B10000">Hết lượt</p>
                                                @elseif ($voucher->max_uses - $voucher->quantity_used == 0)
                                                    <p style="color: #B10000">Hết Voucher</p>
                                                @else
                                                <input class=" d-block" type="radio" name="radioVoucher" id="radio-{{$voucher->id}}" value="{{$voucher->id}}">
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                    <p class="align-middle text-center my-3 w-100" style="color: #B10000">Hiện không có mã giảm giá nào.</p>
                                    @endforelse
                                    
                                </div>
                                @foreach ($orderCarts as $cart)
                                    <input type="hidden" name="cartIds[]" value="{{ $cart->id }}">
                                @endforeach
                                <input type="hidden" name="total_amount" value="{{$totalPay}}">
                                <div class="voucher-wrap-button col-12 text-right pt-2">
                                    <button class="cancel b-radius" id="voucherCancel" type="button">Huỷ</button>
                                    <button class="buy b-radius submitVoucher" type="button" data-voucher="radio">Áp dụng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="total-price-pay-method col-lg-7 col-12">
                    <div class="sum-price pb-2">
                            <div>Tổng tiền hàng :</div> <b class="sum-pay">{{ format_price($sum) }}</b>
                        </div>
                        <div class="shipper-price pb-2">
                            <div>Phí vận chuyển : </div> <b>{{ $feeship ? format_price($feeship->feeship) : 'Chưa rõ' }}</b>
                        </div>
                        <div class="total-pay pb-2">
                            <div>Tổng thanh toán :</div> 
                            <b>{{ format_price($totalPay) }}</b>
                        </div>
                        @if ($user->defaultAddress)
                            
                            <input type="hidden" name="shipping_address" value="{{ $defaultAddress->street }}">
                            <input type="hidden" name="province_id_order" value="{{ $defaultAddress->province_id }}">
                            <input type="hidden" name="district_id_order" value="{{ $defaultAddress->district_id }}">
                            <input type="hidden" name="ward_id_order" value="{{ $defaultAddress->ward_id }}">
                            <div class="button-pay text-right"><button class="b-radius" type="submit">Đặt hàng</button></div>
                        @else
                            <div class="button-pay text-right"><a href="{{route("profile.address")}}" class="b-radius" >Thêm địa chỉ để đặt hàng</a></div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </form>

    {{-- modal show address --}}
    <div class="address-layer" id="addressShowLayer">
        <form action="{{ route('order.changeAddress') }}" method="POST" id="changeAddressShowForm" >
            <div class="address-modal row" id="addressModal">
                <h6 class="col-12 mt-3 mb-4">Địa chỉ của tôi</h6>
                <div class="address-content-wrap">
                    @foreach ($shippingAddresses as $address)
                        <div class="form-group col-12 row align-items-center" style="margin-left: 0px; margin-right: 0px;">
                            <div class="col-2"><input type="radio" name="radio-address" data-shipping-address-id="{{$address->id}}" {{$address->is_default == true ? 'checked' : ''}}></div>
                            <div class="col-8">
                                <p class="my-1">{{$address->user_name}}</p> 
                                <p class="my-1" style="color: rgba(0,0,0,0.54);">(+84) {{$address->phone}}</p>
                                <p class="my-1" style="color: rgba(0,0,0,0.54);">{{$address->street}}, {{$address->ward->ward_name}}, {{$address->district->district_name}}, {{$address->province->province_name}}</p>
                                @if ($address->is_default == true)
                                    <p class="my-1" style="font-size: 10px; color: #B10000;">Mặc định</p>
                                @endif
                            </div>
                            <div class="col-2">
                                <button class="btn btn-update-address" style="font-size: 10px;background-color: transparent;color: #B10000;" data-shipping-address-id="{{$address->id}}" type="button">Cập nhật</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="change-address p-1 b-radius my-2" id="btn-add-address" style="font-size: 10px">Thêm địa chỉ mới</button>
                <input type="hidden" name="shipping-address-id" value="">
                <div class="col-12 text-right">
                    <button class="cancel b-radius" id="addressShowCancel" type="button">Huỷ</button>
                    <button class="buy b-radius" id="submitChangeAddressShow" type="button">Xác nhận</button>
                </div>
            </div>
        </form>
    </div>

    {{-- modal change address --}}
    <div class="address-layer" id="addressLayer">
        <form action="{{ route('order.changeAddress') }}" method="POST" id="changeAddressForm" >
            @csrf
            <div class="address-modal row" id="addressModal">
                <h6 class="col-12 mt-3 mb-4">Cập nhật địa chỉ</h6>
                <div class="form-group col-12">
                    <label class="address-label">Tên người nhận<span class="text-vali">&#9913;</span></label>
                    <div class="">
                        <input type="text" placeholder="Nhập tên người nhận" name="user_name" class="form-control"
                            value="">
                    </div>
                </div>
                <div class="form-group col-lg-6 col-12">
                    <label class="address-label">Địa chỉ<span class="text-vali">&#9913;</span></label>
                    <div class="">
                        <input type="text" placeholder="Nhập địa chỉ" id="addressForm" name="street" class="form-control"
                            value="">
                    </div>
                </div>
                <div class="form-group col-lg-6 col-12">
                    <label class="address-label">Số điện thoại<span class="text-vali">&#9913;</span></label>
                    <div class="">
                        <input type="text" placeholder="Nhập số điện thoại" id="phoneNumberForm" name="phone"
                            class="form-control" value="">
                    </div>
                </div>
                <div class="form-group col-12">
                    <label class="address-label">Thành Phố<span class="text-vali">&#9913;</span></label></label>
                    <div class="">
                        <select class="text-center form-control font-weight-500" name="province_id"
                            id="province_select">
                            <option class=" text-center" value="0" disabled>Tỉnh/Thành phố *</option>
                            @foreach ($provinces as $province)
                                <option class=" text-center" value="{{ $province->id }}">
                                    {{ $province->province_name }}</option>
                            @endforeach
                        </select>
                        @error('province_id')
                            <div style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-lg-6 col-12">
                    <label class="address-label">Quận/Huyện <span
                            class="text-vali">&#9913;</span></label></label>
                    <div class="">
                        <select class="text-center form-control font-weight-500" name="district_id"
                            id="district_select">
                            <option value="0" class=" text-center" disabled>Quận/Huyện *</option>
                            <option value="0" class=" text-center" disabled>Vui lòng chọn thành phố trước
                            </option>
                        </select>
                        @error('district_id')
                            <div style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-lg-6 col-12">
                    <label class="address-label">Phường/Thị xã <span
                            class="text-vali">&#9913;</span></label></label>
                    <div class="">
                        <select class="text-center form-control font-weight-500" name="ward_id"
                            id="ward_select">
                            <option value="0" class=" text-center" disabled>Phường/Thị xã *</option>
                            <option value="0" class=" text-center" disabled>Vui lòng chọn quận huyện trước
                            </option>
                        </select>
                        @error('ward_id')
                            <div style="width: 100%;margin-top: .25rem;font-size: 80%;color: #dc3545;">
                                {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-12">
                    <input type="radio" name="type_address" value="{{TypeAddressEnums::HOME->value}}" checked> <span class="ml-1" style="color: rgba(0,0,0,0.54);">Nhà riêng</span>
                    <input class="ml-3" type="radio" name="type_address" value="{{TypeAddressEnums::OFFICE->value}}"> <span class="ml-1" style="color: rgba(0,0,0,0.54);">Văn phòng</span>
                    <input class="ml-3" type="radio" name="type_address" value="{{TypeAddressEnums::OTHER->value}}"> <span class="ml-1" style="color: rgba(0,0,0,0.54);">Khác</span>
                </div>

                <div class="form-group col-12">
                    <input type="checkbox" name="is_default"> <span class="ml-1" style="color: rgba(0,0,0,0.54);">Đặt làm mặc định</span>
                </div>
                <input type="hidden" name="shipping_address_id" value="">
                <div class="col-12 text-right">
                    <button class="cancel b-radius" id="addressCancel" type="button">Huỷ</button>
                    <button class="buy b-radius" id="submitChangeAddress" type="submit">Thay đổi</button>
                </div>
            </div>
        </form>
    </div>

    @section('script')
        
        <script>
            $(document).ready(function() {
                //address modal

                $('#btnChangeAddress').on('click', function() {
                    $('#addressShowLayer').fadeIn();
                });

                $('#addressShowLayer').on('click', function(e) {
                    if ($(e.target).is('#addressShowLayer')) {
                        $('#addressShowLayer').fadeOut();
                    }
                });
                $('#addressShowCancel').on('click', function(e) {
                    if ($(e.target).is('#addressShowCancel')) {
                        $('#addressShowLayer').fadeOut();
                    }
                });

                var districtId = 0;
                var wardId = 0;
                $('.btn-update-address').on('click', function (e){

                    var addressId = $(this).data('shipping-address-id');
                    var addressSelected = @json($shippingAddresses).find(function(address) {
                        return address.id == addressId;
                    });
                    $('#changeAddressForm input[name="shipping_address_id"]').val(addressId);
                    $('#changeAddressForm input[name="user_name"]').val(addressSelected.user_name);
                    $('#changeAddressForm input[name="phone"]').val(addressSelected.phone);
                    $('#changeAddressForm input[name="street"]').val(addressSelected.street);
                    districtId = addressSelected.district_id;
                    wardId = addressSelected.ward_id;
                    $('#province_select').val(addressSelected.province_id).change();
                    $('#changeAddressForm input[name="is_default"]').prop('checked', addressSelected.is_default);
                    $('#changeAddressForm input[name="type_address"][value="' + addressSelected.type_address + '"]').prop('checked', true);
                    $('#addressShowLayer').fadeOut();
                    $('#submitChangeAddress').text('Thay đổi')
                    $('#addressLayer').fadeIn();
                });

                $('#btn-add-address').on('click', function (e) {
                    $('#changeAddressForm input[name="user_name"]').val('');
                    $('#changeAddressForm input[name="phone"]').val('');
                    $('#changeAddressForm input[name="street"]').val('');
                    $('#changeAddressForm input[name="is_default"]').prop('checked', false);
                    $('#changeAddressForm input[name="type_address"][value="' + @json(TypeAddressEnums::HOME->value) + '"]').prop('checked', true);
                    $('#province_select').val(0).change();
                    $('#district_select').trigger('change');

                    $('#changeAddressForm').attr('action', '{{ route("order.addAddress") }}');
                    
                    $('#addressShowLayer').fadeOut();
                    $('#submitChangeAddress').text('Thêm địa chỉ')
                    $('#addressLayer').fadeIn();
                })

                $('#district_select').on('change', function() {
                    districtId = $(this).val();
                    
                    $.ajax({
                        url: '{{ route("web.ward") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            districtId: districtId
                        },
                        success: function(response) {
                            $('#ward_select').empty().append('<option value="0"  selected>Phường/Thị xã *</option>');  // get ward
                            $.each(response.wards, function(index, ward) {
                                $('#ward_select').append(`<option value=${ward.id} ${ward.id == wardId ? 'selected' : ''}>${ward.ward_name}</option>`);
                            });
                        }
                    });
                });


                $('#province_select').on('change', function() {
                    var provinceId = $(this).val(); // Lấy giá trị được chọn
                    $.ajax({
                    url: '{{ route("web.district") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        provinceId: provinceId
                    },
                    success: function(response) {
                        $('#district_select').empty().append('<option value="0"  selected>Quận/Huyện *</option>'); // get lại district
                        $.each(response.districts, function(index, district) {
                            $('#district_select').append(`<option value=${district.id} ${district.id == districtId ? 'selected' : ''}>${district.district_name}</option>`);
                        });

                        $('#ward_select').empty().append('<option value="0"  selected>Phường/Thị xã *</option>'); // set lại ward
                    $('#ward_select').append('<option value="0" >Vui lòng chọn quận huyện trước</option>');
                    $('#district_select').trigger('change')
                    }
                    });
                });

                // $('#btnChangeAddress').on('click', function() {
                //     $('#addressLayer').fadeIn();
                // });

                // $('#addressLayer').on('click', function(e) {
                //     if ($(e.target).is('#addressLayer')) {
                //         $('#addressLayer').fadeOut();
                //     }
                // });
                $('#addressCancel').on('click', function(e) {
                    if ($(e.target).is('#addressCancel')) {
                        $('#addressLayer').fadeOut();
                        $('#addressShowLayer').fadeIn();
                    }
                });

                $('input[name="radio-address"]').change(function() {
                    var addressId = $(this).closest('.form-group').find('.btn-update-address').data('shipping-address-id');
                    $('input[name="shipping-address-id"]').val(addressId);  // dùng trong modal
                });

                $('#submitChangeAddressShow').on('click', function () {
                    var addressIdSelected = $('input[name="radio-address"]:checked').data('shipping-address-id');
                    
                    var addressSelected = @json($shippingAddresses).find(function(address) {
                        return address.id == addressIdSelected;
                    });
                    $('.infor-address').html('<b class="mr-3">' + addressSelected.user_name + ' (+84) ' + addressSelected.phone + ' </b>' 
                                        + addressSelected.street + ', ' + addressSelected.ward.ward_name + ', ' + addressSelected.district.district_name + ', ' + addressSelected.province.province_name 
                                        );
                    $('input[name="shipping_address"]').val(addressSelected.street);
                    $('input[name="province_id_order"]').val(addressSelected.province_id);
                    $('input[name="district_id_order"]').val(addressSelected.district_id);
                    $('input[name="ward_id_order"]').val(addressSelected.ward_id);
                    $('#addressShowLayer').fadeOut();

                    // lấy lại danh sách mã giảm giá
                    $.ajax({
                        url: @json(route('order.getVouchers')),
                        data: {
                            province_id: addressSelected.province_id,
                            district_id: addressSelected.district_id,
                            ward_id: addressSelected.ward_id
                        },
                        method: 'GET',
                        success: function(response) {
                            var voucherList = $('.voucher-list');
                            voucherList.empty();
                            var htmlItem = ``;
                            if (response.vouchers.length > 0) {
                                response.vouchers.forEach(voucher =>{
                                    
                                    var userUsedArray = voucher.user_used ? voucher.user_used.split(',') : [];
                                    var numberUsed = userUsedArray.filter(function(id) {
                                        return parseInt(id) === @json(Auth::id());
                                    }).length;
                                    
                                    htmlItem += `
                                    <div class="voucher-item col-12" > 
                                        <div class="voucher-image col-3">
                                                <img src="${ getImage(voucher.photo) }" alt="voucher">
                                        </div>
                                        <div class="voucher-content col-6">
                                            <p>Tiêu đề: ${voucher.title}</p>
                                            <p>Giảm: ${ voucher.type == @json(TypeDiscountEnums::PERCENT->value) ? voucher.value + ' %' : format_price(voucher.value)}</p>
                                            ${
                                                voucher.type == @json(TypeDiscountEnums::PERCENT->value) ?
                                                `<p>Giảm tối đa: ${format_price(voucher.max_value)}</p>` : ''
                                            }
                                            <p>Số lần dùng: ${ numberUsed +' /'+ voucher.limit_uses}</p>
                                            <p>Còn lại: ${voucher.max_uses - voucher.quantity_used}</p>
                                            <p>Hết hạn sau: ${dateRemaining(voucher.end_time)}</p>
                                            ${ 
                                            
                                                voucher.scope_type == @json(TypeDiscountScopeEnums::REGIONAL->value) ? 
                                                `<p class="mt-1 text-left">
                                                    Chỉ cho khu vực: 
                                                        ${voucher.ward ? voucher.ward.ward_name + ', ' : ''}
                                                        ${voucher.district ? voucher.district.district_name + ', ' : ''}
                                                        ${voucher.province ? voucher.province.province_name + '.' : ''}
                                                        </p>` : ''
                                            }
                                        </div>
                                        <div class="voucher-button col-3">
                                            ${
                                                voucher.max_uses - voucher.quantity_used == 0 ?
                                                `<p style="color: #B10000">Hết Voucher</p>` :
                                                `<input class=" d-block" type="radio" name="radioVoucher" id="radio-${voucher.id}" value="${voucher.id}">`
                                            }
                                        </div>
                                    </div>
                                    `

                                })
                            } else {
                                htmlItem = `<p class="align-middle text-center my-3 w-100" style="color: #B10000">Hiện không có mã giảm giá nào.</p>`;
                            }
                            
                            voucherList.append(htmlItem);
                            $('#voucherShowHtml').remove();
                        },
                    })
                });



                // voucher modal
                $('#btnVoucher').on('click', function() {
                    $('#voucherLayer').fadeIn();
                });

                $('#voucherLayer').on('click', function(e) {
                    if ($(e.target).is('#voucherLayer')) {
                        $('#voucherLayer').fadeOut();
                    }
                });
                $('#voucherCancel').on('click', function(e) {
                    if ($(e.target).is('#voucherCancel')) {
                        $('#voucherLayer').fadeOut();
                    }
                });
            });
        </script>

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
            
            function format_price(price) {
                if (isNaN(price)) {
                    return '0 VNĐ';
                }
                const formattedPrice = price.toLocaleString('vi-VN', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
                return `${formattedPrice} VNĐ`;
            }
            function dateRemaining(endDate) {
                const utcOffset = 7 * 60;
                const currentDate = new Date(new Date().getTime() + utcOffset * 60 * 1000);
                const endDateParsed = new Date(endDate);

                const totalMinutesCurrent = Math.floor(currentDate.getTime() / 60000);
                const totalMinutesEnd = Math.floor(endDateParsed.getTime() / 60000);
                const minutesRemaining = totalMinutesEnd - totalMinutesCurrent;
                if (minutesRemaining < 0) {
                    return '0 ngày 0 giờ 0 phút.';
                }
                const daysRemaining = Math.floor(minutesRemaining / (60 * 24));
                const hoursRemaining = Math.floor((minutesRemaining % (60 * 24)) / 60);
                const minutesFinalRemaining = minutesRemaining % 60;

                return `${daysRemaining} ngày ${hoursRemaining} giờ ${minutesFinalRemaining} phút.`;
            }

            function calculateDiscountedPrice(type,originalPrice, value, maxValue) {
                let discountAmount = value;
                if(type == 1) { // %
                    discountAmount = (originalPrice * value) / 100;
                    if(discountAmount > maxValue) discountAmount = maxValue;
                }else {
                    
                    discountAmount = value;
                    
                    if (discountAmount > maxValue) {
                        discountAmount = maxValue;
                    }
                }

                let discounted = originalPrice - discountAmount;
                
                if(discounted < 0) {
                    discounted = 0;
                }
                return discounted;
            }

            $(document).ready(function() {
                var voucherId = null;

                // submit address
                $('#submitChangeAddress').click(function(e) {
                    e.preventDefault();
                    let addressValue = $('#addressForm').val();
                    let phoneNumberValue = $('#phoneNumberForm').val();
                    let nameValue = $('#changeAddressForm input[name="user_name"]').val();
                    $('.error-message').remove();
                    let hasError = false;
                    if (!nameValue) {
                        $('#changeAddressForm input[name="user_name"]').after('<span class="error-message text-danger my-1" style="font-size: 10px">Vui lòng nhập tên người nhận.</span>');
                        hasError = true;
                    }
                    if (!addressValue) {
                        $('#addressForm').after('<span class="error-message text-danger my-1" style="font-size: 10px">Vui lòng nhập địa chỉ.</span>');
                        hasError = true;
                    }
                    var phoneRegex = /^[0-9]{10,11}$/;
                    if (!phoneNumberValue) {
                        $('#phoneNumberForm').after('<span class="error-message text-danger my-1" style="font-size: 10px">Vui lòng nhập số điện thoại.</span>');
                        hasError = true;
                    }else if (!phoneRegex.test(phoneNumberValue)) {
                        console.log("alo");
                        
                        $('#phoneNumberForm').after('<span class="error-message text-danger my-1" style="font-size: 10px">Số điện thoại không hợp lệ. Vui lòng nhập lại.</span>');
                        hasError = true;
                    }
                    if (hasError) {
                        return; // Dừng hàm
                    }

                    var formData = $('#changeAddressForm').serialize();
                    
                    $.ajax({
                        url: $('#changeAddressForm').attr('action'),
                        type: 'POST',
                        data: formData,
                        success: function(response) {

                            if (response.status == 200) {
                                localStorage.setItem('toastMessage', response.message);
                                localStorage.setItem('toastType', 'success');
                                location.reload();
                            } else {
                                toastr.error(response.message, null, {
                                    positionClass: 'toast-bottom-left'
                                });
                            }
                        },
                        error: function(response) {
                        }
                    });
                });

                //submit voucher
                $('.submitVoucher').click(function(e) {
                    let vouchers = @json($vouchers);
                    var voucherSelected = null;
                    e.preventDefault();
                    var voucherCodeInput = $('#voucherCode').val();
                    var voucherType = $(this).data('voucher');
                    if(voucherType == 'code' && voucherCodeInput.length > 0) {
                        
                        vouchers.forEach(function(item) {
                            if(item.code == voucherCodeInput){
                                voucherSelected = item;
                                voucherId = item.id;
                                
                            } 
                        })
                        
                        if(!voucherSelected) {
                            $('#errorCode').empty();
                            $('#errorCode').append(`
                                <p class="text-danger code-error my-1">Mã giảm giá không hợp lệ</p>
                            `)
                            return;
                        }
                        
                        if(voucherSelected ) {
                            if(voucherSelected.user_used.split(',').filter(id => id == @json(Auth::id())).length >= voucherSelected.limit_uses) {
                                $('#errorCode').empty();
                                $('#errorCode').append(`
                                    <p class="text-danger code-error my-1">Đã hết lượt dùng voucher này</p>
                                `)
                                return;
                            }
                        }
                        if(voucherSelected) {
                            if(voucherSelected.max_uses == voucherSelected.quantity_used) {
                                $('#errorCode').empty();
                                $('#errorCode').append(`
                                    <p class="text-danger code-error">Voucher này đã hết</p>
                                `)
                                return;
                            }
                        }
                        
                    }else {
                        var selectedVoucherId = $('input[name="radioVoucher"]:checked').val();
                        vouchers.forEach(function(item) {
                            if(item.id == selectedVoucherId){
                                voucherSelected = item;
                                voucherId = item.id;
                            } 
                        })
                    }
                    
                    if (voucherSelected != null) {
                        $('#voucherShowHtml').remove();
                            let voucherHtml =`
                                <div class="voucher-item col-12 mt-2" id="voucherShowHtml" style="border: 1px solid #B10000; border-left: 2px solid #B10000;border-top-style: dotted; border-right-style: dotted; border-bottom-style: dotted; border-left-style: groove;">
                                        <div class="voucher-image col-3">
                                            <img src="${getImage(voucherSelected.photo)}" alt="voucher">
                                        </div>
                                        <div class="voucher-content col-9" style="border-right:none">
                                            <p>Tiêu đề: ${voucherSelected.title}</p>
                                            <p>Giảm: ${voucherSelected.type == 1 ? `${voucherSelected.value} %` : format_price(voucherSelected.value)}</p>
                                            ${voucherSelected.type == 1 ? `<p>Giảm tối đa: ${format_price(voucherSelected?.max_value)}</p>` : ''}
                                            
                                            <p>Hết hạn sau: ${dateRemaining(voucherSelected?.end_time)}</p>
                                            <input type="hidden" name="discount_id" value="${voucherSelected.id}"/>
                                        </div>
                                </div>`;
                            $('#voucherLayer').fadeOut();
                            $('#btnVoucher').before(voucherHtml);
                            $('#btnVoucher').text('Đổi voucher');
                            $('.sum-pay').text(format_price(calculateDiscountedPrice(voucherSelected.type, @json($sum), voucherSelected.value, voucherSelected.max_value)))
                            toastr.success("Áp dụng mã thành công", null, {positionClass: 'toast-bottom-left'});
                        }
                        return;
                });

            });


            var toastMessage = localStorage.getItem('toastMessage');
            var toastType = localStorage.getItem('toastType');

            if (toastMessage) {
                // Hiển thị thông báo và xóa nó sau khi hiển thị
                if (toastType === 'success') {
                    toastr.success(toastMessage, null, {
                        positionClass: 'toast-bottom-left'
                    });
                } else {
                    toastr.error(toastMessage, null, {
                        positionClass: 'toast-bottom-left'
                    });
                }

                localStorage.removeItem('toastMessage');
                localStorage.removeItem('toastType');
            }
        </script>

        
    @endsection
@endsection
