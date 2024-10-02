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
    @endphp
    <div class="content-address">
        <div class="address-wrap container px-0">
            <div class="border-pay"></div>
            <div class="content-address-main">
                <div class="location-address"><i class="fa-solid fa-location-dot"></i> Địa chỉ nhận hàng</div>
                <div class="information-receive"><b>{{ $user->name }} (+84) {{ $user->phone_number }}</b>
                    {{ $user->address }}, {{ $user->ward->ward_name }}, {{ $user->district->district_name }},
                    {{ $user->province->province_name }}
                    <button class="change-address p-1 b-radius" id="btnChangeAddress">Thay đổi</button>
                </div>
                <div class="address-layer" id="addressLayer">
                    <form action="{{ route('order.changeAddress') }}" method="POST" id="changeAddressForm" >
                        @csrf
                        <div class="address-modal row" id="addressModal">
                            <h6 class="col-12 mt-3 mb-4">Cập nhật địa chỉ</h6>
                            <div class="form-group col-lg-6 col-12">
                                <label class="address-label">Địa chỉ<span class="text-vali">&#9913;</span></label>
                                <div class="">
                                    <input type="text" placeholder="Nhập địa chỉ" id="addressForm" name="address" class="form-control"
                                        value="{{ old('address') ? old('address') : $user->address }}">
                                </div>
                            </div>
                            <div class="form-group col-lg-6 col-12">
                                <label class="address-label">Số điện thoại<span class="text-vali">&#9913;</span></label>
                                <div class="">
                                    <input type="text" placeholder="Nhập số điện thoại" id="phoneNumberForm" name="phone_number"
                                        class="form-control" value="{{ $user->phone_number }}">
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

                            <div class="form-group col=lg-6 col-12">
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

                            <div class="col-12 text-right">
                                <button class="cancel b-radius" id="addressCancel" type="button">Huỷ</button>
                                <button class="buy b-radius" id="submitChangeAddress" type="submit">Thay đổi</button>
                            </div>
                        </div>
                    </form>
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
                        @foreach ($carts as $cart)
                            @php
                                $sum += $cart->products->price * $cart->quantity;
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
                                            style="color: #B10000">{{ $carts->count() }}</span>): <b>{{ format_price($sum) }}</b></div>
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
                                                        $discountUser = $voucher->getDiscountUserByUserId(Auth::id());
                                                        $numberUsed = $discountUser ? $discountUser->number_used : 0;
                                                    @endphp
                                                <p>Số lần dùng: {{ $numberUsed .' /'. $voucher->limit_uses}}</p>
                                                <p>Còn lại: {{$voucher->max_uses - $voucher->quantity_used}}</p>
                                                <p>Hết hạn sau: {{dateRemaining($voucher->end_time)}}</p>
                                            </div>
                                            <div class="voucher-button col-3">
                                                @if ($voucher->getDiscountUserByUserId(Auth::id()) && $voucher->getDiscountUserByUserId(Auth::id())->number_used == $voucher->limit_uses)
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
                                @foreach ($carts as $cart)
                                    <input type="hidden" name="carts[]" value="{{ $cart }}">
                                @endforeach
                                <input type="hidden" name="total_amount" value="{{$sum}}">
                                <input type="hidden" name="shipping_address" value="{{ $user->address .', ' . $user->ward->ward_name .', ' . $user->district->district_name .', ' . $user->province->province_name }}">
                                <div class="voucher-wrap-button col-12 text-right pt-2">
                                    <button class="cancel b-radius" id="voucherCancel" type="button">Huỷ</button>
                                    <button class="buy b-radius submitVoucher" type="button" data-voucher="radio">Áp dụng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="total-price-pay-method col-lg-7 col-12">
                        <div class="sum-price pb-2">
                            <div>Tổng tiền hàng</div> <b class="sum-pay">{{ format_price($sum) }}</b>
                        </div>
                        {{-- <div class="shipper-price pb-2">
                            <div>Phí vận chuyển</div> <b>50.100 VNĐ</b>
                        </div>
                        <div class="total-pay pb-2">
                            <div>Tổng thanh toán</div> <b>29.850.100 VNĐ</b>
                        </div> --}}
                        <div class="button-pay text-right"><button class="b-radius" type="submit">Đặt hàng</button></div>
                    </div>
                </div>

            </div>
        </div>
    </form>
    @section('script')
        @include('admin.customer.province')
        
        <script>
            $(document).ready(function() {
                //address modal
                $('#btnChangeAddress').on('click', function() {
                    $('#addressLayer').fadeIn();
                });

                $('#addressLayer').on('click', function(e) {
                    if ($(e.target).is('#addressLayer')) {
                        $('#addressLayer').fadeOut();
                    }
                });
                $('#addressCancel').on('click', function(e) {
                    if ($(e.target).is('#addressCancel')) {
                        $('#addressLayer').fadeOut();
                    }
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
                }
                let discounted = originalPrice - discountAmount;
                return discounted;
            }

            $(document).ready(function() {
                var voucherId = null;

                // submit address
                $('#submitChangeAddress').click(function(e) {
                    e.preventDefault();
                    let addressValue = $('#addressForm').val();
                    let phoneNumberValue = $('#phoneNumberForm').val();
                    $('.error-message').remove();
                    let hasError = false;
                    if (!addressValue) {
                        $('#addressForm').after('<span class="error-message text-danger my-1" style="font-size: 10px">Vui lòng nhập địa chỉ.</span>');
                        hasError = true;
                    }
                    if (!phoneNumberValue) {
                        $('#phoneNumberForm').after('<span class="error-message text-danger my-1" style="font-size: 10px">Vui lòng nhập số điện thoại.</span>');
                        hasError = true;
                    }
                    if (hasError) {
                        return; // Dừng hàm
                    }

                    var formData = $('#changeAddressForm').serialize();
                    console.log(addressValue + "|" + phoneNumberValue);
                    
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
                                console.log(voucherSelected);
                                
                            } 
                        })
                        
                        if(!voucherSelected) {
                            $('#errorCode').empty();
                            $('#errorCode').append(`
                                <p class="text-danger code-error">Mã giảm giá không hợp lệ</p>
                            `)
                            return;
                        }
                        if(voucherSelected && voucherSelected.discount_users.length > 0) {
                            var userId = {{ Auth::id() }};
                            var discountUser = voucherSelected.discount_users.find(discountUser => discountUser.user_id === userId);
                            console.log(discountUser);
                            if(voucherSelected.limit_uses == discountUser.number_used) {
                                $('#errorCode').empty();
                                $('#errorCode').append(`
                                    <p class="text-danger code-error">Đã hết lượt dùng voucher này</p>
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
