@extends('web.layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('/css/product.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/product-detail.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/cart.css') }}" />
@endsection
@section('title')
    HOME
@endsection
@section('content')
@php
    $cartCount = 0;
    foreach ($carts as $cart) {
        if($cart->products->getProductUnitById($cart->product_unit_id)->quantity > 0) {
            $cartCount++;
        }
    }
    $allowSend = true;
@endphp
    <div class="content">
        <div class="content-wrap container">
            @if (count($carts) > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th></th>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Số tiền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($carts as $cart)
                            <tr class="text-center">
                                <td class="align-middle">
                                    <input type="checkbox" class="custom-checkbox" data-cart-id="{{ $cart->id }}" {{$cart->products->getProductUnitById($cart->product_unit_id)->quantity > 0 ? '' : 'disabled'}}/>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex">
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
                                            <div class="text-left type-product">
                                                @if ( !empty($cart->products->getProductUnitById($cart->product_unit_id)))
                                                <div class="type-show">
                                                    @if (! empty($cart->products->getProductUnitById($cart->product_unit_id)->size) && ! empty($cart->products->getProductUnitById($cart->product_unit_id)->color))
                                                <p>Phân loại hàng:</p>
                                                    <div class="type-size-{{$cart->id}}"> &nbsp; size {{$cart->products->getProductUnitById($cart->product_unit_id)->size}}, </div>
                                                    <div class="type-color-{{$cart->id}}">&nbsp; màu {{$cart->products->getProductUnitById($cart->product_unit_id)->color}}, </div>
                                                    <div class="type-quantity-{{$cart->id}}">
                                                        @if ($cart->products->getProductUnitById($cart->product_unit_id)->quantity > 0)
                                                            &nbsp;  còn {{$cart->products->getProductUnitById($cart->product_unit_id)->quantity}} sản phẩm.
                                                        @else
                                                        <p class='text-danger'>&nbsp; Hết hàng.</p>
                                                        @endif
                                                    </div>
                                                    <button class="btn-type-product" style="border: none" id="btnTypeProduct{{$cart->id}}" ><i class="fa-regular fa-pen-to-square"></i></button>
                                                    @else
                                                    <div class="type-quantity-{{$cart->id}}">
                                                        @if ($cart->products->getProductUnitById($cart->product_unit_id)->quantity > 0)
                                                            &nbsp;  còn {{$cart->products->getProductUnitById($cart->product_unit_id)->quantity}} sản phẩm.
                                                        @else
                                                        <p class='text-danger'>&nbsp; Hết hàng.</p>
                                                        @endif
                                                    </div>
                                                    @endif

                                                </div>
                                                <div class="type-product-layer" id="typeProductLayer{{$cart->id}}" data-cart="{{$cart->products->productUnits}}" data-productunitid="{{$cart->products->getProductUnitById($cart->product_unit_id)->id}}">
                                                    <div class="type-product-modal" id="typeProductModal{{$cart->id}}">
                                                        <p class="type-product-title">Đổi Loại hàng {{$cart->id}}</p>
                                                        <div class="type-product-content" id="typeProductContent{{$cart->id}}">
                                                            <table class="table table-unit">
                                                                <thead>
                                                                  <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">Màu</th>
                                                                    <th scope="col">SIZE</th>
                                                                    <th scope="col">Còn lại</th>
                                                                  </tr>
                                                                </thead>
                                                                <tbody id="typeProductTable{{$cart->id}}">
                                                
                                                                </tbody>
                                                              </table>
                                                        </div>
                                                        <div id="errorCode">
        
                                                        </div>
                                                        <div class="type-product-wrap-button col-12 text-right pt-2">
                                                            <button class="cancel b-radius btn btn-outline-dark" id="typeProductCancel{{$cart->id}}" type="button">Huỷ</button>
                                                            <button class="buy b-radius typeProductSubmit btn-apply" type="button" data-cartId="{{$cart->id}}" data-productunitid="0"  data-href="{{route('cart.updateProductUnit', $cart->id)}}" >Áp dụng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
        
                                            </div>
                                        </div>
                                    </div>
                                    
                                </td>
                                <td class="align-middle">
                                    <span class="original-price">{{ format_price($cart->products->price) }}</span>
                                </td>
                                <td class="align-middle td-quantity-{{$cart->id}}">
                                    @if ($cart->products->getProductUnitById($cart->product_unit_id)->quantity > 0)
                                            <div class="number-input number-input-{{$cart->id}}" data-cartid="{{$cart->id}}">
                                                <button class="minus-{{$cart->id}} minus" data-cartid="{{$cart->id}}">-</button>
                                                <input class="quantity-{{$cart->id}} quantity" type="number" data-productunitquantity="{{$cart->products->getProductUnitById($cart->product_unit_id)->quantity}}" data-url="{{route('cart.updateQuantityCart', $cart->id)}}" data-productunitid="{{$cart->product_unit_id}}" data-cartid="{{$cart->id}}" value="{{ $cart->quantity }}" min="1"
                                                    max="100">
                                                <button class="plus-{{$cart->id}} plus" data-cartid="{{$cart->id}}">+</button>
                                            </div>
                                        @else
                                            <p class="text-danger">Hết hàng</p>
                                    @endif

                                    @if ($cart->quantity > $cart->products->getProductUnitById($cart->product_unit_id)->quantity  && $cart->products->getProductUnitById($cart->product_unit_id)->quantity > 0)
                                        <div class="text-danger mt-2">
                                            Chỉ còn {{$cart->products->getProductUnitById($cart->product_unit_id)->quantity}} sản phẩm loại này
                                        </div>
                                    @endif
                                </td>
                                <td class="total-amount align-middle td-amount-{{$cart->id}}">
                                    {{ format_price($cart->products->price * $cart->quantity) }}</td>
                                <td class="align-middle">
                                    <a href="{{ route('cart.destroy', $cart->id) }}" class="btn btn-danger"
                                        style="color: white;"><i class="fa-regular fa-trash-can"></i></a>
                                    <!-- <button class="btn btn-primary">Tìm sản phẩm tương tự</button> -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="content-2-wrap container d-flex justify-content-between align-items-center py-5">
                    <div class="d-flex align-items-center">
                        <input type="checkbox" class="all-check mr-2" />
                        <span>Chọn tất cả ({{ $cartCount }})</span>
                        <a href="#" class="btn btn-link text-danger" id="clear-cart">Xóa tất cả</a>
                    </div>
                    <div>
                        <span>Tổng thanh toán sản phẩm: </span>
                        <b class="total">
                            {{ format_price(
                                $carts->sum(function ($cart) {
                                    return $cart->products->sale_price * $cart->quantity;
                                }),
                            ) }}
                        </b>
                    </div>
                    <a class="btn btn-success" href="{{ route('order.index') }}" id="buyButton">Mua hàng</a>
                </div>
            @else
                <div class="text-center w-100 py-5">
                    <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào trong giỏ.</span>
                </div>
            @endif
        </div>
    </div>
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa bài viết này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal xác nhận xóa -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa tất cả sản phẩm trong giỏ hàng?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal thông báo chọn sản phẩm -->
    <div class="modal fade" id="noSelectionModal" tabindex="-1" role="dialog" aria-labelledby="noSelectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noSelectionModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Vui lòng chọn sản phẩm trước khi xóa.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="selectProductModal" tabindex="-1" role="dialog" aria-labelledby="noSelectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noSelectionModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Vui lòng chọn sản phẩm trước mua hàng.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="quantityProductModal" tabindex="-1" role="dialog" aria-labelledby="noSelectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noSelectionModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Có sản phẩm không còn đủ số lượng vui lòng đợi hoặc giảm số lượng tương ứng.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

@section('script')
<script>
        // Hàm định dạng tiền tệ
        function formatCurrency(value) {
            return value.toLocaleString('en-US', {
                style: 'currency',
                currency: 'VND',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).replace('₫', '').trim() + ' VNĐ';
        }

        // Hàm tính tổng số tiền cho một sản phẩm
        function calculateTotalAmount(row) {
            const price = parseFloat(row.querySelector('.original-price').textContent.replace(/[₫,.]/g,
            '')); // Lấy giá gốc và loại bỏ các ký tự không cần thiết
            const quantity = parseInt(row.querySelector('.quantity').value); // Lấy số lượng
            const totalAmount = price * quantity; // Tính tổng tiền
            row.querySelector('.total-amount').textContent = formatCurrency(totalAmount); // Hiển thị tổng tiền
            calculateGrandTotal(); // Cập nhật tổng thanh toán
        }

        // Hàm tính tổng thanh toán cho tất cả các sản phẩm được chọn
        function calculateGrandTotal() {
            let grandTotal = 0;
            let allChecked = true; // Kiểm tra xem tất cả checkbox có được chọn không
            
            document.querySelectorAll('tbody tr ').forEach(row => {
                const isChecked = row.querySelector('.custom-checkbox'); // Kiểm tra ô checkbox có được chọn không
                
                if (isChecked !== null) {
                    if(isChecked.checked){
                    const totalAmount = parseFloat(row.querySelector('.total-amount').textContent.replace(
                            /[VNĐ,.]/g, '').trim()); // Lấy tổng tiền
                            grandTotal += totalAmount; // Cộng dồn vào tổng thanh toán
                        } else {
                            if(!isChecked.disabled) { // nếu không disable và không được chọn
                                allChecked = false; 
                            }
                        }
                }
            });

            document.querySelector('.total').textContent = formatCurrency(grandTotal); // Hiển thị tổng thanh toán cuối cùng
            document.querySelector('.all-check').checked = allChecked; // Đặt trạng thái của checkbox "Chọn tất cả"
        }

        // // Tăng số lượng
        // document.querySelectorAll(".plus").forEach(button => {
        //     button.addEventListener("click", function() {
        //         const input = this.previousElementSibling; // Lấy ô nhập số lượng
        //         input.value = parseInt(input.value) + 1; // Tăng số lượng lên 1
        //         calculateTotalAmount(this.closest('tr')); // Cập nhật tổng tiền cho sản phẩm
        //     });
        // });

        // // Giảm số lượng
        // document.querySelectorAll(".minus").forEach(button => {
        //     button.addEventListener("click", function() {
        //         const input = this.nextElementSibling; // Lấy ô nhập số lượng
        //         if (parseInt(input.value) > 1) { // Đảm bảo số lượng không nhỏ hơn 1
        //             input.value = parseInt(input.value) - 1; // Giảm số lượng xuống 1
        //             calculateTotalAmount(this.closest('tr')); // Cập nhật tổng tiền cho sản phẩm
        //         }
        //     });
        // });

        // Cập nhật tổng tiền khi người dùng nhập vào ô số lượng
        document.querySelectorAll(".number-input input").forEach(input => {
            input.addEventListener("input", function() {
                calculateTotalAmount(this.closest('tr')); // Cập nhật tổng tiền cho sản phẩm
            });
        });

        // Chọn/deselect tất cả checkbox
        document.querySelector('.all-check').addEventListener('change', function() {
            const isChecked = this.checked; // Lấy trạng thái checkbox "Chọn tất cả"
            document.querySelectorAll('.custom-checkbox').forEach(checkbox => {
                if(!checkbox.disabled){
                    checkbox.checked = isChecked; // Thiết lập trạng thái cho checkbox nếu k disable
                }
            });
            calculateGrandTotal(); // Cập nhật tổng thanh toán
        });

        // Cập nhật tổng thanh toán khi checkbox của từng sản phẩm thay đổi
        document.querySelectorAll('.custom-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                
                calculateGrandTotal(); // Cập nhật tổng thanh toán
            });
        });

        // Xóa tất cả sản phẩm
        document.getElementById('clear-cart').addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
            const allChecked = document.querySelector('.all-check').checked; // Kiểm tra checkbox "Chọn tất cả"

            if (allChecked) {
                // Hiển thị modal xác nhận
                $('#confirmDeleteModal').modal('show');
            } else {
                // Hiển thị modal thông báo nếu không có sản phẩm nào được chọn
                $('#noSelectionModal').modal('show');
            }
        });


        // Xử lý xác nhận xóa
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            // Chuyển hướng đến route xóa giỏ hàng
            window.location.href = "{{ route('cart.clear') }}";
        });
    </script>

    <script>
        document.querySelectorAll('.custom-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateBuyButton);
        });
        document.querySelectorAll('.all-check').forEach(checkbox => {
            checkbox.addEventListener('change', updateBuyButton);
        });

        function updateBuyButton() {
            const selectedCartIds = [];
            let isValid = true;
            document.querySelectorAll('.custom-checkbox:checked').forEach(checkbox => {
                const cartId = checkbox.getAttribute('data-cart-id');
                selectedCartIds.push(cartId);
            });
            
            // Cập nhật URL của nút Mua hàng
            const buyButton = document.getElementById('buyButton');
            const baseUrl = buyButton.getAttribute('href').split('?')[0];
            const queryString = selectedCartIds.length > 0 ? `?cart_ids[]=${selectedCartIds.join('&cart_ids[]=')}` : '';
            buyButton.setAttribute('href', baseUrl + queryString);

            

            if (selectedCartIds.length === 0) {
                buyButton.removeEventListener('click', navigateToOrder); // Ngăn hành động chuyển hướng
                buyButton.addEventListener('click', showSelectProductModal);
            } else {
                // kiểm tra xem hàng chọn có vượt quá số lượng không
                selectedCartIds.forEach(cartId => {
                    const checkbox = document.querySelector(`.custom-checkbox[data-cart-id="${cartId}"]`);
                    if (checkbox) {
                        const quantityInput = document.querySelector(`.quantity[data-cartid="${cartId}"]`); // tìm input số lượng tương ứng với cartId
                        if (quantityInput) {
                            const productUnitQuantity = parseInt(quantityInput.dataset.productunitquantity); // Lấy số lượng tối đa
                            const currentQuantity = parseInt(quantityInput.value); // Lấy giá trị hiện tại

                            if (currentQuantity > productUnitQuantity) {
                                isValid = false; // Không hợp lệ nếu số lượng vượt quá
                            }
                        }
                    }
                });

                
                buyButton.removeEventListener('click', showSelectProductModal);
                buyButton.addEventListener('click', navigateToOrder);
                if(!isValid) {
                    buyButton.removeEventListener('click', navigateToOrder); // Ngăn hành động chuyển hướng
                    buyButton.addEventListener('click', showQuantityProductModal);

                }
            }
        }

        function showSelectProductModal(event) {
            event.preventDefault(); 
            $('#selectProductModal').modal('show');
        }

        function showQuantityProductModal(event) {
            event.preventDefault(); 
            $('#quantityProductModal').modal('show');
        }

        function navigateToOrder(event) {}
        updateBuyButton()
    </script>

    <script>
        $(document).ready(function() {
            $('.btn-type-product').on('click', function() {
                let cartId = $(this).attr('id').replace('btnTypeProduct', '');
                const datas = $('#typeProductLayer' + cartId).data('cart');
                let productUnitIdSelected = $('#typeProductLayer' + cartId).data('productunitid');
                
                let html = `Không có dữ liệu về loại hàng này`;
                const cartProductUnits = @json($carts).map(cart => cart.product_unit_id);
                if(datas.length > 0 ) {
                    datas.forEach((unit, index) => {
                        html += `
                            <tr>
                                ${cartProductUnits.includes(unit.id) && productUnitIdSelected != unit.id ?
                                `<td><p class="text-success"> Đã có </p></td>` 
                                : unit.quantity > 0 ? `<td><input type="radio" name="radio-unit" value="${unit.id}" data-size="${unit.size}" data-color="${unit.color}" data-quantity="${unit.quantity}" data-total-product="${unit.quantity}" ></td>` : `<td><p class="text-danger">Hết hàng</p></td>`
                                }
                                <td>${unit.color}</td>
                                <td>${unit.size}</td>
                                <td>${unit.quantity}</td>
                            </tr>
                        `;
                    });
                }
                $('#typeProductTable' + cartId).empty();
                $('#typeProductTable' + cartId).append(html);
                $('#typeProductLayer' + cartId).show();
            });

            var sizeShow = '';
            var colorShow = '';
            var quantityShow = '';
            $(document).on('change', 'input[name="radio-unit"]', function() {
                const selectedUnitId = $(this).val(); // Lấy giá trị của radio được chọn
                sizeShow = $(this).data('size');  // truyền đi để thay đổi ngoài giao diện
                colorShow = $(this).data('color');  
                quantityShow = $(this).data('quantity');  
                $('.typeProductSubmit').data('productunitid', selectedUnitId);
            });

            $(document).on('click', '.typeProductSubmit', function() {
                const cartId = $(this).data('cartid');
                const productUnitId = $(this).data('productunitid');
                const productUnit = $('.typeProductSubmit').data('productunit');
                const urlInput = $(`.quantity-${cartId}`).data('url'); 
                const url = $(this).data('href');
                
                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: {
                        productUnitId: productUnitId, 
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        let cart = response.cart;
                        $(`.type-size-${cartId}`).text(`Size ${sizeShow}`);
                        $(`.type-color-${cartId}`).text(`Màu ${colorShow}`)    
                        $(`.type-quantity-${cartId}`).html(quantityShow > 0 ? `Số lượng ${quantityShow}` : '<p class="text-danger">Hết hàng</p>')
                        $(`.quantity-${cartId}`).data('productunitid', productUnitId).trigger('change') // cập nhật số lượng
                        $(`.td-quantity-${cartId}`).html(
                            quantityShow > 0 ?
                                `<div class="number-input number-input-${cartId}" data-cartid="${cartId}">
                                    <button class="minus-${cartId} minus" data-cartid="${cartId}">-</button>
                                    <input class="quantity-${cartId} quantity" type="number" data-url="${urlInput}" data-productunitid="${cart.product_unit_id}" data-cartid="${cart.id}" value="${cart.quantity }" min="1"
                                        max="100">
                                    <button class="plus-${cart.id} plus" data-cartid="${cart.id}">+</button>
                                </div>` : `<p class="text-danger">Hết hàng</p>`
                        )
                        toastr.success("Áp dụng loại hàng thành công", null, {positionClass: 'toast-bottom-left'});
                        $('#typeProductLayer' + cartId).fadeOut();

                    },
                    error: function(xhr) {
                        // Xử lý lỗi
                    }
                });
            });

            $('.cancel').on('click', function() {
                const cartId = $(this).attr('id').replace('typeProductCancel', '');
                $('#typeProductLayer' + cartId).fadeOut();
            });
           
            $('.type-product-layer').on('click', function(e) {
                    if ($(e.target).is('.type-product-layer')) {
                        $('.type-product-layer').fadeOut();
                    }
            });

            $(document).on("click", ".plus", function() {
                
                const cartId = $(this).data('cartid');
                const input = $(`.quantity-${cartId}`);
                let productUnitId = $(`.quantity-${cartId}`).data('productunitid')
                
                let currentValue = parseInt(input.val()) || 0;
                currentValue += 1;

                let carts = @json($carts);
                let cartSelected = carts.find(cart => cart.id === cartId);

                let quantityProductUnit = cartSelected.products.product_units.find(product_unit => product_unit.id == productUnitId).quantity;
                
                if(input.val() < quantityProductUnit) {
                    input.val(currentValue).trigger('change');
                    calculateTotalAmount(this.closest('tr'));
                }
            });

            // Giảm số lượng
            $(document).on("click", ".minus", function() {
                const cartId = $(this).data('cartid');
                const input = $(`.quantity-${cartId}`);
                let currentValue = parseInt(input.val()) || 0;

                if (currentValue > 1) {
                    currentValue -= 1;
                    input.val(currentValue).trigger('change');
                    calculateTotalAmount(this.closest('tr'));
                    updateBuyButton()
                }
            });

            let checkTimeout;

            $(document).on("change", ".quantity", function() {
                
                const cartId = $(this).data('cartid');
                const input = $(`.quantity-${cartId}`);
                let productUnitId = $(`.quantity-${cartId}`).data('productunitid')
                let url = $(`.quantity-${cartId}`).data('url')
                let carts = @json($carts);
                let cartSelected = carts.find(cart => cart.id === cartId);
                
                let quantityProductUnit = cartSelected.products.product_units.find(product_unit => product_unit.id == productUnitId).quantity;
                
                if(input.val() > quantityProductUnit) {
                    input.val(quantityProductUnit);
                }
                if(input.val() < 1) {
                    input.val(1);
                }

                clearTimeout(checkTimeout); // xoá sau khi thay đổi 2s
        
                checkTimeout = setTimeout(function() {
                    
                    $.ajax({
                        url: url, 
                        method: 'PUT',
                        data: {
                            quantity: input.val(),
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                        },
                        error: function(xhr) {
                        }
                    });
                }, 1000);
            });
        });
    </script>
@endsection
@endsection
