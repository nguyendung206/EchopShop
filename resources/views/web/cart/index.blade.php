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
<div class="content">
    <div class="content-wrap container">
        @if(count($carts) > 0)
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
                        <input type="checkbox" class="custom-checkbox" data-cart-id="{{$cart->id}}"/>
                    </td>
                    <td class="align-middle">
                        <div class="d-flex">
                            <div class="img-item">
                                <img src="{{ getImage($cart->products->photo) }}" alt="{{ $cart->products->name }}" />
                            </div>
                            <div class="item-details ml-3">
                                <div class="name-item-cart mb-2">
                                    {{ $cart->products->name }}
                                </div>
                                <div class="item-meta mb-2">
                                    <p>{!! $cart->products->description !!}</p>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle">
                        <span class="original-price">{{format_price($cart->products->price)}}</span>
                    </td>
                    <td class="align-middle">
                        <div class="number-input">
                            <button class="minus">-</button>
                            <input class="quantity" type="number" value="{{ $cart->quantity }}" min="1" max="100">
                            <button class="plus">+</button>
                        </div>
                    </td>
                    <td class="total-amount align-middle">{{ format_price($cart->products->price * $cart->quantity) }}</td>
                    <td class="align-middle">
                        <a href="{{route('cart.destroy', $cart->id)}}" class="btn btn-danger" style="color: white;"><i class="fa-regular fa-trash-can"></i></a>
                        <!-- <button class="btn btn-primary">Tìm sản phẩm tương tự</button> -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="content-2-wrap container d-flex justify-content-between align-items-center py-5">
            <div class="d-flex align-items-center">
                <input type="checkbox" class="all-check mr-2" />
                <span>Chọn tất cả ({{ $carts->count() }})</span>
                <a href="#" class="btn btn-link text-danger" id="clear-cart">Xóa tất cả</a>
            </div>
            <div>
                <span>Tổng thanh toán sản phẩm: </span>
                <b class="total">
                    {{
                    format_price($carts->sum(function($cart) {
                        return $cart->products->sale_price * $cart->quantity;
                    })) 
                }}
                </b>
            </div>
            <a class="btn btn-success" href="{{route('order.index')}}" id="buyButton">Mua hàng</a>
        </div>
        @else
        <div class="text-center w-100 py-5">
            <span class="" style="color:rgb(177,0,0);">Không có sản phẩm nào trong giỏ.</span>
        </div>
        @endif
    </div>
</div>
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
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
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
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
<div class="modal fade" id="noSelectionModal" tabindex="-1" role="dialog" aria-labelledby="noSelectionModalLabel" aria-hidden="true">
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
        const price = parseFloat(row.querySelector('.original-price').textContent.replace(/[₫,.]/g, '')); // Lấy giá gốc và loại bỏ các ký tự không cần thiết
        const quantity = parseInt(row.querySelector('.quantity').value); // Lấy số lượng
        const totalAmount = price * quantity; // Tính tổng tiền
        row.querySelector('.total-amount').textContent = formatCurrency(totalAmount); // Hiển thị tổng tiền
        calculateGrandTotal(); // Cập nhật tổng thanh toán
    }

    // Hàm tính tổng thanh toán cho tất cả các sản phẩm được chọn
    function calculateGrandTotal() {
        let grandTotal = 0;
        let allChecked = true; // Kiểm tra xem tất cả checkbox có được chọn không

        document.querySelectorAll('tbody tr').forEach(row => {
            const isChecked = row.querySelector('.custom-checkbox').checked; // Kiểm tra ô checkbox có được chọn không
            if (isChecked) {
                const totalAmount = parseFloat(row.querySelector('.total-amount').textContent.replace(/[VNĐ,.]/g, '').trim()); // Lấy tổng tiền
                grandTotal += totalAmount; // Cộng dồn vào tổng thanh toán
            } else {
                allChecked = false; // Nếu có checkbox không được chọn
            }
        });

        document.querySelector('.total').textContent = formatCurrency(grandTotal); // Hiển thị tổng thanh toán cuối cùng
        document.querySelector('.all-check').checked = allChecked; // Đặt trạng thái của checkbox "Chọn tất cả"
    }

    // Tăng số lượng
    document.querySelectorAll(".plus").forEach(button => {
        button.addEventListener("click", function() {
            const input = this.previousElementSibling; // Lấy ô nhập số lượng
            input.value = parseInt(input.value) + 1; // Tăng số lượng lên 1
            calculateTotalAmount(this.closest('tr')); // Cập nhật tổng tiền cho sản phẩm
        });
    });

    // Giảm số lượng
    document.querySelectorAll(".minus").forEach(button => {
        button.addEventListener("click", function() {
            const input = this.nextElementSibling; // Lấy ô nhập số lượng
            if (parseInt(input.value) > 1) { // Đảm bảo số lượng không nhỏ hơn 1
                input.value = parseInt(input.value) - 1; // Giảm số lượng xuống 1
                calculateTotalAmount(this.closest('tr')); // Cập nhật tổng tiền cho sản phẩm
            }
        });
    });

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
            checkbox.checked = isChecked; // Thiết lập trạng thái cho tất cả checkbox
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
        document.querySelectorAll('.custom-checkbox:checked').forEach(checkbox => {
            selectedCartIds.push(checkbox.getAttribute('data-cart-id'));
        });

        // Cập nhật URL của nút Mua hàng
        const buyButton = document.getElementById('buyButton');
        const baseUrl = buyButton.getAttribute('href').split('?')[0];
        const queryString = selectedCartIds.length > 0 ? `?cart_ids[]=${selectedCartIds.join('&cart_ids[]=')}` : '';
        buyButton.setAttribute('href', baseUrl + queryString);
    }
</script>

@endsection