@extends('admin.layout.app')
@section('title')
@lang('Thêm giảm giá')
@endsection
@section('content')
<div class="backnow">
    <div class="backpage">
        <a href="{{route('admin.order.index')}}" class="back btn"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg></a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">Thêm mới Đơn hàng</h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.order.store')}}" method="POST" enctype="multipart/form-data" class="row">
                    @csrf
                    <div class="col-lg-5">
                        Danh sách sản phẩm
                        <div class=" form-group " style="height: 80vh;overflow-y: scroll;">
                            @foreach ($products as $product)
                                <div class="d-flex my-5 align-items-center justify-content-between">
                                    <img src="{{getImage($product->photo)}}" class="rounded" alt="" style="width: 80px; height: 80px">
                                    <p style="margin-top: 0px; margin-bottom: 0px;">{{$product->name}}</p>
                                    <p style="margin-top: 0px; margin-bottom: 0px;">{{format_price($product->price)}}</p>
                                    <p style="margin-top: 0px; margin-bottom: 0px;">{{$product->type->label()}}</p>
                                    <input type="checkbox"  class="mr-3 product-checkbox" data-id="{{$product->id}}" data-product="{{$product}}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="form-group row select-user-div">
                            <label class="col-sm-12 col-from-label font-weight-500">Chọn khách hàng</label>
                            <select class="text-center font-weight-500 form-control select-user" name="customerId">
                                <option value="">Chọn khách hàng</option>
                                @foreach ($customers as $customer)
                                    <option value="{{$customer->id}}" data-shipping-address="{{ $customer->address }}, {{ $customer->ward->ward_name }}, {{ $customer->district->district_name }},{{ $customer->province->province_name }}">{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-from-label font-weight-500">Chọn mã giảm giá</label>
                            <select class="text-center font-weight-500 form-control @error('type') is-invalid  @enderror" name="discountId" id="discount-select">
                                <option value="">Chọn mã giảm giá</option>
                                <option value="" disabled>Vui lòng chọn khách hàng trước</option>
                            </select>
                        </div>

                        <div class="form-group list-unit" style="height: 45vh;overflow-y: scroll;margin-right: -15px; margin-left: -15px;">
                            <div style="height: 100%; text-align: center" class="no-order">

                                <img src="{{asset('/img/image/noorder.png')}}" alt="" style="height: 100%">
                            </div>
                        </div>

                        <div class="form-group total-price">
                            <p style="font-weight: bold">Tổng tiền đơn hàng </p>
                            <div class="row">
                                <p class="num-order-product col-6">Số mặt hàng đã đặt: 0</p>
                                <p class="quantity-order-product col-6">Số lượng mặt hàng: 0</p>
                                <p class="total-price-product col-4">Tổng tiền: 0 VNĐ</p>
                                <p class="discount-price col-4">Giảm giá: Chưa chọn giảm giá.</p>
                                <p class="discounted-price col-4">Thành tiền: 0 VNĐ</p>
                            </div>
                        </div>
                        <div style="display: none" class="input-hidden">
                            <input type="hiden" name="shipping_address" value="" class="shipping_address">
                            <input type="hiden" name="total_amount" value="" class="total_amount">
                        </div>
                        <div class="form-group button-submit d-flex justify-content-between">
                            <a class="btn btn-dark" style="color: white;" href="{{route('admin.order.index')}}">Trở về</a>
                            <button class="btn btn-primary" type="submit">Xác nhận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@section('script')
<script>
    function previewPhoto(input) {
        const preview = document.getElementById('photo_preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
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
        let roundedPrice = Math.round(price);
        let formattedPrice = roundedPrice.toLocaleString('en-US');
        return formattedPrice + ' VNĐ';
    }
    $(document).ready(function() {
        $('.product-checkbox').on('change', function() {
            var productId = $(this).data('id');
            
            if ($(this).is(':checked')) {
                $('.no-order').hide();
                let productSelected = $(this).data('product');
                
                var productHtml = `
                        <div class="col-12 product-unit-${productSelected.id} row align-items-center border-bottom my-2" id="product-${productSelected.id}" >
                            <div class="col-4 mb-2">
                                <img src="${getImage(productSelected.photo)}" class="rounded " style="width: 80px; height: 80px;" />
                            </div>
                            <p class="col-4 mb-2">Tên sản phẩm: ${productSelected.name}</p>
                            <p class="col-4 mb-2">Giá: ${format_price(productSelected.price)}</p>
                    `;
                        
                    productSelected.product_units.forEach(unit => {
                        productHtml += `
                            <div class="col-12 unit row align-items-center unit-${unit.id} mb-2" id="unit-${unit.id}">
                                ${unit.type == 1 ?
                                `<p class="col-3" style="margin-top: 0px; margin-bottom: 0px;">Số lượng: ${unit.quantity > 0 ? unit.quantity : 'Hết hàng'}</p>
                                <p class="col-2"></p>
                                <p class="col-2"></p>
                                <div class="col-2"><input type="checkbox" class="checkbox-unit checkbox-unit-${unit.id}" data-unit-id="${unit.id}" data-unit-quantity="${unit.quantity}" data-unit-price="${productSelected.price}" data-product-id="${productSelected.id}" ${unit.quantity > 0 ? "" : "disabled"}></div>
                                ${unit.quantity > 0 ? '' : '<p class="col-3 text-danger">Không thể thêm sản phẩm này</p>'}
                                `
                                 : 
                                `<p class="col-3" style="margin-top: 0px; margin-bottom: 0px;">Màu: ${unit.color}</p>
                                <p class="col-2" style="margin-top: 0px; margin-bottom: 0px;">Size: ${unit.size}</p>
                                <p class="col-2" style="margin-top: 0px; margin-bottom: 0px;">Số lượng: ${unit.quantity > 0 ? unit.quantity : 'Hết hàng'}</p>
                                <div class="col-2">
                                    <input type="checkbox" class="checkbox-unit checkbox-unit-${unit.id}" data-unit-id="${unit.id}" data-unit-quantity="${unit.quantity}" data-unit-price="${productSelected.price}" data-product-id="${productSelected.id}" ${unit.quantity > 0 ? "" : "disabled"}>
                                </div>
                                ${unit.quantity > 0 ? '' : '<p class="col-3 text-danger">Không thể thêm sản phẩm này</p>'}`
                                }
                            </div>
                        `;
                    });

                    productHtml += `</div>`;

                    $('.list-unit').append(productHtml);

            }else {
                let productSelected = $(this).data('product');
                $(`.product-unit-${productSelected.id}`).remove();
            }

            if ($('.product-checkbox:checked').length === 0) {
                $('.no-order').show(); 
            }

            updateNumOrderProduct()
            updateQuantityOrderProduct()
            updatePriceOrderProduct()
            updateDiscount()
            updateTotalDiscountedPrice()

        });

        $(document).on('change', '.checkbox-unit', function () {
            
            var productUnitId = $(this).data('unit-id');
            var productId = $(this).data('product-id');
            var unitQuantity = $(this).data('unit-quantity');
            var unitPrice = $(this).data('unit-price');
            
            if ($(this).is(':checked')) {
                var inputHtml = `
                    <div class="col-3  input-quantity-${productId} input-quantity-unit-${productUnitId}">
                        <input type="number" id="quantity-${productUnitId}" name="quantity-${productUnitId}" data-unit-quantity="${unitQuantity}" data-unit-price="${unitPrice}" value="1" class="input-quantity form-control input-quantity-unit-${productUnitId}" placeholder="Nhập số lượng"> 
                    </div>
                `;
                $(`.unit-${productUnitId}`).append(inputHtml);
            } else {
                $(`.input-quantity-unit-${productUnitId}`).remove();
            }
            $(document).on('keydown', '.input-quantity', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Ngăn chặn hành động mặc định của phím Enter
                }
            });
            updateNumOrderProduct()
            updateQuantityOrderProduct()
            updatePriceOrderProduct()
            updateDiscount()
            updateTotalDiscountedPrice()

        })

        // số lượng sản phẩm đã chọn
        function updateNumOrderProduct() {
            var numSelected = $('.radio-unit:checked').length;
            $('.num-order-product').text(`Số lượng sản phẩm đã đặt: ${numSelected}`);
        }

        $(document).on('change', '.input-quantity', function () {
            var inputQuantity = $(this).val();
            var limitQuantity = $(this).data('unit-quantity');
            
            if (inputQuantity > limitQuantity) {
                
                $(this).val(limitQuantity);    
            } 
            if(inputQuantity < 1) {
                $(this).val(1);
            }

            updateQuantityOrderProduct()
            updatePriceOrderProduct()
            updateDiscount()
            updateTotalDiscountedPrice()
        });

        // số lượng mua
        function updateQuantityOrderProduct() {
            var totalQuantity = 0;
            $('.input-quantity').each(function() {
                var quantity = parseInt($(this).val(), 10) || 0;
                totalQuantity += quantity;
            });
            $('.quantity-order-product').text(`Số lượng mặt hàng: ${totalQuantity}`);
        }

        var totalPriceOrigin = 0;
        function updatePriceOrderProduct() {
            totalPriceOrigin = 0;
            $('.input-quantity').each(function() {
                
                var price = parseInt($(this).data('unit-price')) || 0;
                var quantity = parseInt($(this).val(), 10) || 0;
                totalPriceOrigin += price * quantity;
            });
            $('.total-price-product').text(`Tổng tiền: ${format_price(totalPriceOrigin)}`);
        }

        var totalDiscountAmount = 0;
        $('#discount-select').on('change', function() {
            
            updateDiscount();
            updateTotalDiscountedPrice();
        });
        $('.select-user').on('change', function () {
            var selectedOption = $('.select-user').find('option:selected');
            var shippingAddress = selectedOption.data('shipping-address');
            $('.shipping_address').val(shippingAddress); // đưa vào địa chỉ giao hàng
            if (selectedOption.val() != "") {

                $.ajax({
                    url:  '{{route('admin.discount.getDiscountJson')}}' ,
                    type: 'GET',
                    success: function (response) {
                        
                        let discounts = response.discounts;
                        let discountHtml = `
                            <option value="">Chọn mã giảm giá</option>
                        `;

                        // Lặp qua mảng discounts
                        $.each(discounts, function (index, discount) {
                            let userIdArray = discount.user_used.split(','); // lấy ra mảng người dùng
                            let countUserId = userIdArray.filter(userId => userId == selectedOption.val()).length; // đếm số lượt dùng
                            discountHtml += `
                                <option value="${discount.id}" 
                                    data-value="${discount.value}" 
                                    data-max-value="${discount.max_value}" 
                                    data-discount-type="${discount.type}"
                                    ${discount.limit_uses <= countUserId ? 'disabled' : ''}
                                    class = "${discount.limit_uses <= countUserId ? 'text-danger' : ''}"
                                    >
                                    Giảm: ${discount.type == 1 ? discount.value + '%' : format_price(discount.value)}; 
                                    tối đa: ${format_price(discount.max_value)};
                                    lượt dùng:  ${countUserId}/${discount.limit_uses} 
                                </option>
                            `;
                        });

                        $('#discount-select').html(discountHtml);
                    }
                });
            }else {
                $('#discount-select').html(`
                                <option value="">Chọn mã giảm giá</option>
                                <option value="" disabled>Vui lòng chọn khách hàng trước</option>
                `);
            }
        });

        function updateDiscount() {
            totalDiscountAmount = 0;
            var selectedOption = $('#discount-select').find('option:selected');
            var discountValue = selectedOption.data('value');
            if(!discountValue) {
                return $('.discount-price').text(`Giảm giá: Chưa chọn giảm giá.`);
            }
            var discountMaxValue = selectedOption.data('max_value');
            var discountType = selectedOption.data('discount-type');

            // Giả sử bạn đã có biến totalPriceOrigin được tính toán ở đâu đó
            totalDiscountAmount = calculateDiscountAmount(discountType, totalPriceOrigin, discountValue, discountMaxValue);
            
            if (totalPriceOrigin == 0) {
                totalDiscountAmount = discountValue;
                $('.discount-price').text(`Giảm giá: ${totalDiscountAmount} ${discountType == 1 ? ' %' : ' VNĐ'}`);
            } else {
                $('.discount-price').text('Giảm giá: ' + format_price(totalDiscountAmount) || '0 VNĐ');
            }
        }

        function calculateDiscountAmount(type,originalPrice, value, maxValue) {
                let discountAmount = value;
                if(type == 1) { // %
                    discountAmount = (originalPrice * value) / 100;
                    if(discountAmount > maxValue) {
                        
                        discountAmount = maxValue;
                    }
                }else {
                    
                    discountAmount = value;
                    
                    if (discountAmount > maxValue) {
                        discountAmount = maxValue;
                    }
                }

                return discountAmount;
        }

        var totalDiscountedPrice = 0;
        function updateTotalDiscountedPrice() {
            totalDiscountedPrice = totalPriceOrigin - totalDiscountAmount;
            $('.discounted-price').text('Thành tiền: ' + format_price(totalDiscountedPrice) || '0 VNĐ');
        }

        // gửi form
        $(document).on('submit', 'form', function(e) {
            e.preventDefault(); 
            
            let isValid = true; 
            $('.total_amount').val(totalPriceOrigin);
            
            $('.text-error').remove();
            let userId = $('.select-user').val();
            if(!userId) {
                isValid = false;
                $('.select-user-div').append(`
                <p class="text-danger text-error">Vui lòng chọn người dùng</p
                `)
            }
            if ($('.input-quantity').length === 0) {
                isValid = false;
                $('.list-unit').after(`
                <p class="text-danger text-error">Vui lòng chọn mặt hàng muốn mua</p
                `)
            }

            if (isValid) {
                this.submit(); 
            }
        });
    });

    

</script>

@endsection
@endsection