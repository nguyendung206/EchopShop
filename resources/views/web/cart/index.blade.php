@extends('web.layout.app')
@section('css')
<link rel="stylesheet" href="{{asset('/css/product.css')}}" />
<link rel="stylesheet" href="{{asset('/css/product-detail.css')}}" />
<link rel="stylesheet" href="{{asset('/css/cart.css')}}" />
@endsection
@section('title')
HOME
@endsection
@section('content')
<div class="content">
    <div class="content-wrap container">
        <div class="cart-header">
            <div class="cart-header-wrap">
                <div class="col-lg-1 res-none">
                </div>
                <div class="col-lg-4 col-sm-5  col-5">Sản phẩm</div>
                <div class="col-lg-2 col-2">Đơn giá</div>
                <div class="col-lg-2 col-sm-2  col-1">Số lượng</div>
                <div class="col-lg-2 col-2">Số tiền</div>
                <div class="col-lg-1 col-1">Thao tác</div>
            </div>
        </div>

        <div class="cart-main">
            <div class="cart-item">
                <div class="col-lg-1 col-1">
                    <div class="custom-checkbox"></div>
                </div>
                <div class="col-lg-4 col-4 res-change-item">
                    <div class="img-item">
                        <img src="/assets/img/cart-item-1.png" alt="" />
                    </div>
                    <div class="item-wrap">
                        <div class="name-item-cart line-clamp">
                            IPhone 13 128GB Chính hãng V N/A
                        </div>
                        <div class="change-item line-clamp">Đổi ý miễn phí 15 ngày</div>
                        <div class="expire-day-item line-clamp">15 ngày miễn phí trả hàng</div>
                    </div>
                    <div class="class-item">
                        <div class="open-list-class">
                            Phân loại hàng <i class="fa-solid fa-caret-down"></i>
                            <div class="list-class">
                                <div>Yellow</div>
                                <div>Green</div>
                                <div>Black</div>
                            </div>
                        </div>
                        <b>green</b>
                    </div>
                </div>
                <div class="col-lg-2 col-2 unit-price">
                    <b>16.900.000</b> 14.490.000 đ
                </div>
                <div class="number-input col-lg-2 col-2 quantity-item">
                    <button class="minus">-</button>
                    <input type="number" value="0" min="0" max="100">
                    <button class="plus">+</button>
                </div>
                <div class="col-lg-2 col-2 total-amount">đ14.900.000</div>
                <div class="col-lg-1 col-1 action-item">
                    <button>xoá</button> <button>Tìm sản phẩm tương tự</button>
                </div>
            </div>
            <div class="cart-item">
                <div class="col-lg-1 col-1">
                    <div class="custom-checkbox"></div>
                </div>
                <div class="col-lg-4 col-4 res-change-item">
                    <div class="img-item">
                        <img src="/assets/img/cart-item-1.png" alt="" />
                    </div>
                    <div class="item-wrap">
                        <div class="name-item-cart line-clamp">
                            IPhone 13 128GB Chính hãng V N/A
                        </div>
                        <div class="change-item line-clamp">Đổi ý miễn phí 15 ngày</div>
                        <div class="expire-day-item line-clamp">15 ngày miễn phí trả hàng</div>
                    </div>
                    <div class="class-item">
                        <div class="open-list-class">
                            Phân loại hàng <i class="fa-solid fa-caret-down"></i>
                            <div class="list-class">
                                <div>Yellow</div>
                                <div>Green</div>
                                <div>Black</div>
                            </div>
                        </div>
                        <b>green</b>
                    </div>
                </div>
                <div class="col-lg-2 col-2 unit-price">
                    <b>16.900.000</b> 14.490.000 đ
                </div>
                <div class="number-input col-lg-2 col-2 quantity-item">
                    <button class="minus">-</button>
                    <input type="number" value="0" min="0" max="100">
                    <button class="plus">+</button>
                </div>
                <div class="col-lg-2 col-2 total-amount">đ14.900.000</div>
                <div class="col-lg-1 col-1 action-item">
                    <button>xoá</button> <button>Tìm sản phẩm tương tự</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-2">
    <div class="content-2-wrap container">
        <div class="col-lg-1 col-1">
            <div class="custom-checkbox all-check"></div>
        </div>
        <div class="col-lg-5 col-5 main-content-item">
            <div class="checked-item">Chọn tất cả (13)</div>
            <div class="delete-item">Xoá</div>
            <div class="filter-item">Bỏ sản phẩm không hoạt động</div>
        </div>
        <div class="col-lg-4 col-4 total-price">
            <div>Tổng thanh toán (1 sản phẩm):</div>
            <div><span>₫14.900.000</span></div>
        </div>
        <div class="col-lg-2 col-2 order-button"><button>mua hàng</button></div>
    </div>
</div>
<script>
    const listMinus = document.querySelectorAll(".minus")
    listMinus.forEach(item =>
        item.addEventListener("click", function() {
            const input = this.nextElementSibling;
            if (input.value > input.min) {
                input.value = parseInt(input.value) - 1;
            }
        })
    )

    const listPlus = document.querySelectorAll(".plus")
    listPlus.forEach(item =>
        item.addEventListener("click", function() {
            const input = this.previousElementSibling;
            if (Number(input.value) < Number(input.max)) {
                input.value = parseInt(input.value) + 1;
            }
        })
    )
</script>
<script>
    const allCheck = document.querySelector('.all-check')
    allCheck.addEventListener('click', function() {
        const listcheckbox1 = document.querySelectorAll('[class*="custom-checkbox"]')
        if (document.querySelector('.all-check.checked')) {
            this.classList.remove('checked');
            listcheckbox1.forEach(item =>
                item.classList.remove('checked'))

        } else {
            this.classList.add('checked');
            listcheckbox1.forEach(item =>
                item.classList.add('checked'))
        }
    })
</script>
<script>
    const listcheckbox = document.querySelectorAll('[class*="custom-checkbox"]')
    const sumCheck = 0;
    listcheckbox.forEach(item =>
        item.addEventListener('click', function() {
            this.classList.toggle('checked');
            if (listcheckbox.length - document.querySelectorAll(".all-check").length == document.querySelectorAll('[class*="custom-checkbox checked"]').length - document.querySelectorAll(".all-check.checked").length) {
                document.querySelector('.all-check').classList.add('checked')
            } else {
                document.querySelector('.all-check').classList.remove('checked')
            }
        })
    )
</script>
@endsection