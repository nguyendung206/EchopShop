@extends('web.layout.app')
@section('title')
HOME
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('/css/product.css') }}">
<link rel="stylesheet" href="{{ asset('/css/product-detail.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('slick/slick.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('slick/slick-theme.css') }}" />
@endsection
@section('content')

<div class="breakcrumb-1 my-4">
    <div class="breakcrumb-wrap container">
        <div class="breakcrumb-item">
            Echop
            <div class="arrow"></div>
        </div>

        <div class="breakcrumb-item">
            Mỹ phẩm
            <div class="arrow"></div>
        </div>
        <div class="breakcrumb-item">
            Son môi
            <div class="arrow"></div>
        </div>
        <div class="breakcrumb-item breakcrumb-last-item">
            Son MAC
            <div class="arrow last-arrow"></div>
        </div>
    </div>
</div>
<div class="content">
    <div class="content-wrap">
        <div class="main">
            <!--w-c-1 -->
            <div class=" slider slider-nav">
                <div>
                    <img src="{{asset('/img/image/p-1.png')}}" alt="" />
                </div>
                <div>
                    <img src="{{asset('/img/image/p-2.png')}}" alt="" />
                </div>
                <div>
                    <img src="{{asset('/img/image/p-3.png')}}" alt="" />
                </div>
                <div>
                    <img src="{{asset('/img/image/p-4.png')}}" alt="" />
                </div>
            </div>
            <!-- w-c-4 -->
            <div class=" slider slider-for">
                <div>
                    <h3><img src="{{asset('/img/image/main-product.png')}}" alt="" /></h3>
                </div>
                <div>
                    <h3><img src="{{asset('/img/image/p-2.png')}}" alt="" /></h3>
                </div>
                <div>
                    <h3><img src="{{asset('/img/image/p-3.png')}}" alt="" /></h3>
                </div>
                <div>
                    <h3><img src="{{asset('/img/image/p-4.png')}}" alt="" /></h3>
                </div>
            </div>

        </div>
        <div class="w-c-5 information-product">
            <div class="wrap-heart">
                <img src="{{asset('/img/icon/heart-icon.png')}}" alt="" />
            </div>
            <div class="name-product">
                Son Thỏi MAC Mịn Lì Nhẹ Môi 935 Ruby New - Đỏ Thuần 3g Powder Kiss
                Lipstick.
            </div>
            <div class="price-product">600.000 VNĐ</div>
            <div class="detail-product">
                <img src="{{asset('/img/icon/dot-index.png')}}" alt="" /> Chất son kem lì mềm
                mại, che phủ tối đa các khuyết điểm của đôi môi và dễ tán.
            </div>
            <div class="detail-product">
                <img src="{{asset('/img/icon/dot-index.png')}}" alt="" /> Chất son lì với lớp
                lót đặc biệt cho độ lên màu cao mà không bị bóng.
            </div>
            <div class="detail-product">
                <img src="{{asset('/img/icon/dot-index.png')}}" alt="" /> Màu sắc chuẩn, sắc
                nét, thời gian bám màu rất tốt, giữ được màu từ 5-6h.
            </div>
            <div class="detail-product">
                <img src="{{asset('/img/icon/dot-index.png')}}" alt="" /> Công thức đặc biệt
                của M.A.C giúp son lên màu cực kì chuẩn & sắc nét.
            </div>
            <div class="detail-product">
                <img src="{{asset('/img/icon/dot-index.png')}}" alt="" /> Có chứa các thành
                phần làm mềm, chất tạo độ lì Silica, vitamin E.
            </div>
            <div class="detail-product">
                <img src="{{asset('/img/icon/dot-index.png')}}" alt="" /> Bảng màu son mang đậm
                phong cách quyến rũ và phong phú.
            </div>
            <div class="detail-product">
                <img src="{{asset('/img/icon/dot-index.png')}}" alt="" /> Thiết kế đơn giản với
                vỏ đen kinh điển của M.A.C và kiểu dáng gọn gàng, vừa vặn.
            </div>
            <div class="product-button">
                <button>Trao đổi</button>
            </div>
            <div class="product-share">
                <div>chia sẻ</div>
                <div class="icon-wrap">
                    <div><img src="{{asset('/img/image/logos_facebook.png')}}" alt="" /></div>
                    <div><img src="{{asset('/img/image/logos_instagram.png')}}" alt="" /></div>
                    <div><img src="{{asset('/img/image/logos_twitter.png')}}" alt="" /></div>
                    <div><img src="{{asset('/img/image/logos_messenger.png')}}" alt="" /></div>
                </div>
            </div>
        </div>



    </div>
    <div class=" slider slider-nav slider-nav-2">
        <div>
            <h3><img src="{{asset('/img/image/p-1.png')}}" alt="" /></h3>
        </div>
        <div>
            <h3><img src="{{asset('/img/image/p-2.png')}}" alt="" /></h3>
        </div>
        <div>
            <h3><img src="{{asset('/img/image/p-3.png')}}" alt="" /></h3>
        </div>
        <div>
            <h3><img src="{{asset('/img/image/p-4.png')}}" alt="" /></h3>
        </div>
    </div>
</div>
<div class="content-2">
    <div class="content-2-wrap container">
        <div class="row w-100">
            <div class="col-12 col-lg-6 content-2-1">
                <div class="content-2-1-avatar">
                    <img src="{{asset('/img/image/avatar-1.png')}}" alt="" />
                </div>
                <div class="content-2-1-wrap">
                    <div class="name-shop">Chillwipes</div>
                    <div class="address-shop">
                        <img src="{{asset('/img/icon/location-product.png')}}" alt="" /> An Cựu,
                        Huế, Thừa Thiên Huế
                    </div>
                    <div>
                        <button>
                            <img src="{{asset('/img/icon/chat-product.png')}}" alt="" /> Chat ngay
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 content-2-2">
                <div class="content-2-2-wrap">
                    <div class="reviews">
                        Đánh giá
                        <div class="star-wrap">
                            <img src="{{asset('/img/icon/solid-star.png')}}" alt="" />
                            <img src="{{asset('/img/icon/solid-star.png')}}" alt="" />
                            <img src="{{asset('/img/icon/solid-star.png')}}" alt="" />
                            <img src="{{asset('/img/icon/solid-star.png')}}" alt="" />
                            <img src="{{asset('/img/image/thin-star.png')}}" alt="" />
                        </div>
                    </div>
                    <div class="content-2-total">Sản phẩm <b>10</b></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-3">
    <div class="content-3-title">Mô tả sản phẩm</div>
    <div class="content-3-wrap container">
        <div class="content-3-first">
            Lorem Ipsum is simply dummy text of the printing and typesetting
            industry. Lorem Ipsum has been the industry's standard dummy text ever
            since the 1500s, when an unknown printer took a galley of type and
            scrambled it to make a type specimen book. It has survived not only
            five centuries, but also the leap into electronic typesetting,
            remaining essentially unchanged. It was popularised in the 1960s with
            the release of Letraset sheets containing Lorem Ipsum passages Lorem
            Ipsum is simply dummy text of the printing and typesetting industry.
            Lorem Ipsum has been the industry's standard dummy text ever since the
            1500s, when an unknown printer took a galley of type and scrambled it
            to make a type specimen book. It has survived not only five centuries,
            but also the leap into electronic typesetting, remaining essentially
            unchanged. It was popularised in the 1960s with the release of
        </div>
        <div class="content-3-index">
            <div>
                <img src="{{asset('/img/icon/dot-index.png')}}" alt="" />
                <span>Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy</span>
            </div>
            <div>
                <img src="{{asset('/img/icon/dot-index.png')}}" alt="" />
                <span>Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy</span>
            </div>
            <div>
                <img src="{{asset('/img/icon/dot-index.png')}}" alt="" />
                <span>Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever</span>
            </div>
            <div>
                <img src="{{asset('/img/icon/dot-index.png')}}" alt="" />
                <span>Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever</span>
            </div>
            <div>
                <img src="{{asset('/img/icon/dot-index.png')}}" alt="" />
                <span>Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever</span>
            </div>
        </div>
        <div class="content-3-last">
            Lorem Ipsum is simply dummy text of the printing and typesetting
            industry. Lorem Ipsum has been the industry's standard dummy text ever
            since the 1500s, when an unknown printer took a galley of type and
            scrambled it to make a type specimen book. It has survived not only
            five centuries, but also the leap into electronic typesetting,
            remaining essentially unchanged. It was Lorem Ipsum passages Lorem
            Ipsum is simply dummy text of the printing and typesetting industry.
            Lorem Ipsum has been the industry's standard dummy text ever since the
            1500s, when an unknown printer took a galley of type and scrambled it
            to make a type specimen book. It has survived not only five centuries,
            but also the leap into electronic typesetting, remaining essentially
            unchanged. It was popularised in the 1960s with the release of
        </div>
    </div>
</div>
<div class="content-4">
    <div class="content-4-title">Đánh giá chủ shop</div>
    <div class="content-4-wrap container">
        <div class="row main-content-4 slider responsive multiple-items-1">
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reviewr-content">
                <div class="row-1">
                    <div class="row-1-wrap">
                        <div class="row-1-avatar">
                            <img src="{{asset('/img/image/avatar-2.png')}}" alt="" />
                        </div>
                        <div class="row-1-content">
                            <span class="name-reviewer my-1">Ngọc huyền</span>
                            <span class="dob-reviewer my-1">12/10/2023</span>
                            <span class="product-boght my-1"><img src="{{asset('/img/icon/checked.png')}}" alt="" /> Sản phẩm đã
                                mua: <b>Son 3ce</b>,<b>Tẩy trang</b>,<b>sửa rửa mặt</b></span>
                        </div>
                    </div>
                    <div class="row-1-wrap-star">
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/icon/solid-star.png')}}" class="star-icon" alt="" />
                        <img src="{{asset('/img/image/thin-star.png')}}" class="star-icon" alt="" />
                    </div>
                </div>
                <div class="row-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has
                    survived
                </div>
                <div class="row-3">
                    <div class="row-3-wrap">
                        <img src="{{asset('/img/icon/like.png')}}" alt="" />
                        <span>Hữu ích</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="pagination-1">
          <img src="{{asset('/img/image/pagination.png')}}" alt="" />
        </div> -->
    </div>
</div>
<div class="content-5">
    <div class="content-5-title">Xem thêm sản phẩm</div>
    <div class="content-5-wrap container">
        <div class="row main-content-5 responsive slider multiple-items-2">
            <div class="col-lg-3 product-item">
                <div class="product-content">
                    <div class="img-product">
                        <img src="{{asset('/img/image/p-more-1.png')}}" alt="p4" />
                        <img src="{{asset('/img/icon/heart-solid.png')}}" alt="h" />
                    </div>
                    <span class="name-item">Giày sneaker AF1 âm dương phat...</span>
                    <span class="price-item">250.000 đ</span>
                    <div>
                        <button>Mua ngay</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 product-item">
                <div class="product-content">
                    <div class="img-product">
                        <img src="{{asset('/img/image/p-more-2.png')}}" alt="p4" />
                        <img src="{{asset('/img/icon/heart-icon.png')}}" alt="h" />
                    </div>
                    <span class="name-item">Áo khoác hoodie croptop dài tay c...</span>
                    <span class="price-item">450.000 đ</span>
                    <div>
                        <button>Mua ngay</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 product-item">
                <div class="product-content">
                    <div class="img-product">
                        <img src="{{asset('/img/image/p-more-3.png')}}" alt="p4" />
                        <img src="{{asset('/img/icon/heart-icon.png')}}" alt="h" />
                    </div>
                    <span class="name-item">Giày cao gót nữ LCC62 gót vuông...</span>
                    <span class="price-item">650.000 đ</span>
                    <div>
                        <button>Mua ngay</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 product-item">
                <div class="product-content">
                    <div class="img-product">
                        <img src="{{asset('/img/image/p-more-4.png')}}" alt="p4" />
                        <img src="{{asset('/img/icon/heart-icon.png')}}" alt="h" />
                    </div>
                    <span class="name-item">Điện thoại IP14 Pro Max màu tím...</span>
                    <span class="price-item">5.450.000 đ</span>
                    <div>
                        <button>Mua ngay</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 product-item">
                <div class="product-content">
                    <div class="img-product">
                        <img src="{{asset('/img/image/p-more-4.png')}}" alt="p4" />
                        <img src="{{asset('/img/icon/heart-icon.png')}}" alt="h" />
                    </div>
                    <span class="name-item">Điện thoại IP14 Pro Max màu tím...</span>
                    <span class="price-item">5.450.000 đ</span>
                    <div>
                        <button>Mua ngay</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 product-item">
                <div class="product-content">
                    <div class="img-product">
                        <img src="{{asset('/img/image/p-more-4.png')}}" alt="p4" />
                        <img src="{{asset('/img/icon/heart-icon.png')}}" alt="h" />
                    </div>
                    <span class="name-item">Điện thoại IP14 Pro Max màu tím...</span>
                    <span class="price-item">5.450.000 đ</span>
                    <div>
                        <button>Mua ngay</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="{{asset('/slick/slick.min.js')}}"></script>

<script>
    $(".multiple-items-1").slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: false,
        prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa-solid fa-angle-left'></i></button>",
        nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa-solid fa-angle-right'></i></button>",
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });
    $(".multiple-items-2").slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: false,
        prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa-solid fa-angle-left'></i></button>",
        nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa-solid fa-angle-right'></i></button>",
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                },
            },
        ],
    });
</script>

<script>
    $(".slider-for").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: ".slider-nav",
    });
    $(".slider-nav").slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: ".slider-for",
        dots: true,
        focusOnSelect: true,
    });

    $("a[data-slide]").click(function(e) {
        e.preventDefault();
        var slideno = $(this).data("slide");
        $(".slider-nav").slick("slickGoTo", slideno - 1);
    });
</script>
@endsection
@endsection