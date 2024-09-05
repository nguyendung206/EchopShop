@extends('web.layout.app')
@section('content')
<div class="profile-slider">
    <h1 class="profile-heading text-center">hồ sơ của tôi</h1>
</div>
<div class="container-fluid mt-4">
    <div class="menu-profile">
        <div class="row align-items-center">
            <div class="col-6">
                <div class="float-left">
                    <a href="#" class="profile-back">
                        <i class="fa-solid fa-angle-left"></i>
                        Quay lại
                    </a>
                </div>
            </div>
            <div class="col-6">
                <div class="float-right" id="menu-profile-toggle">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
            <div class="col-12">
                <nav class="category-profile" id="category-profile">
                    <ul class="list text-center">
                        <a href="#">
                            <i class="fa-regular fa-circle-user mr-1"></i>
                            Hồ sơ của tôi
                        </a>
                        <a href="#">
                            <i class="fa-solid fa-cart-plus mr-1"></i>
                            Đơn hàng của tôi
                        </a>
                        <a href="#">
                            <i class="fa-regular fa-comment-dots mr-1"></i>
                            Lịch sử chat
                        </a>
                        <a href="#">
                            <i class="fa-regular fa-file-lines mr-1"></i>
                            Quản lý bài đăng
                        </a>
                        <a href="#">
                            <i class="fa-solid fa-crown mr-1"></i>
                            Gói cước của tôi
                        </a>
                        <a href="#">
                            <i class="fa-regular fa-heart mr-1"></i>
                            Đã thích
                        </a>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-3 profile-list">
            <img src="{{asset('/img/avt.jpeg')}}" alt="" class="profile-img">
            <p class="profile-name text-center">Nhi Khánh</p>
            <a class="profile-update-btn text-center">
                <i class="fa-regular fa-pen-to-square"></i>
                Chỉnh sửa
            </a>
            <ul class="list">
                <a href="#">
                    <i class="fa-regular fa-circle-user mr-1"></i>
                    Hồ sơ của tôi
                </a>
                <a href="#">
                    <i class="fa-solid fa-cart-plus mr-1"></i>
                    Đơn hàng của tôi
                </a>
                <a href="#">
                    <i class="fa-regular fa-comment-dots mr-1"></i>
                    Lịch sử chat
                </a>
                <a href="#">
                    <i class="fa-regular fa-file-lines mr-1"></i>
                    Quản lý bài đăng
                </a>
                <a href="#">
                    <i class="fa-solid fa-crown mr-1"></i>
                    Gói cước của tôi
                </a>
                <a href="#">
                    <i class="fa-regular fa-heart mr-1"></i>
                    Đã thích
                </a>
            </ul>
            <div class="advanced-package mb-5">
                <h1 class="profile-name text-center">Gói nâng cao</h1>
                <img src="{{asset('/img/Component.png')}}" alt="">
                <div class="package-text text-center">
                    <p>
                        <strong>100</strong> Bài viết
                    </p>
                    <hr>
                    <p>
                        <strong>200</strong> Bài viết
                    </p>
                </div>
                <a class="package-btn">
                    Đổi gói cược
                </a>
            </div>
        </div>
        <div class="col-lg-9 col-sm-12 col-12 mt-4">
            <form>
                <div class="row">
                    <div class="col-lg-3 col-sm-12 col-12 text-center mb-4">
                        <img src="{{asset('/img/avt.jpeg')}}" alt="" class="profile-img profile-img-2">
                        <a class="profile-update-btn profile-update-btn-2 text-center">
                            <i class="fa-regular fa-pen-to-square"></i>
                            Chỉnh sửa
                        </a>
                    </div>
                    <div class="col-lg-9 col-sm-12 col-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Tên *</label>
                                <input type="email" class="form-control" placeholder="Nhi Khánh">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Số điện thoại *</label>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <img src="{{asset('/img/vietnam.png')}}" alt="" class="img-vietnam">
                                        +84
                                    </div>
                                    <input type="text" class="form-control" id="inlineFormInputGroup"
                                        placeholder="1234567891">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Email *</label>
                            <input type="text" class="form-control"
                                placeholder="khanhnhi123456@gmail.com">
                        </div>
                        <label for="inputState">Địa chỉ *</label>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <select class="form-control">
                                    <option selected>Tỉnh/ Thành phố *</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <select class="form-control">
                                    <option selected>Quận/ Huyện/ Thị xã *</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <select class="form-control">
                                    <option selected>Phường/ Xã/ Thị trấn *</option>
                                    <option>...</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control"
                                placeholder="Địa chỉ chi tiết">
                        </div>
                    </div>
                </div>
                <br>
                <hr class="hr">
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="profile-title">Thông tin bảo mật</h1>
                        <p class="profile-content">Những thông tin dưới đây mang tính bảo mật. Chỉ bạn mới có thể thấy
                            và chỉnh sửa những thông
                            tin này.</p>
                    </div>
                    <div class="col-md-3">
                        <img src="{{asset('/img/upload.png')}}" alt="" class="upload-img">
                        <p class="text-center upload-text">Ảnh CCCD/Hộ chiếu*</p>
                    </div>
                    <div class="col-md-9">
                        <label for="inputEmail4">CCCD/Hộ chiếu*</label>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="email" class="form-control"
                                    placeholder="Số CCCD/ Hộ chiếu">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="password" class="form-control" placeholder="Ngày cấp">
                                <i class="fa-regular fa-calendar-days icon-calendar"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Nơi cấp">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState">Giới tính</label>
                                <select class="form-control">
                                    <option selected>Khác</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Ngày sinh</label>
                                <input type="password" class="form-control"
                                    placeholder="11/11/1998">
                                <i class="fa-regular fa-calendar-days icon-calendar icon-calendar-2"></i>
                            </div>
                        </div>
                        <div class="float-right form-btn">
                            <a type="submit" class="form-btn-cancel">Hủy</a>
                            <a type="submit" class="form-btn-save">Lưu</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection