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
                        <a href="{{route('web.profile.index', Session::get('user')->id)}}">
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
            <img src="{{getImage($user->avatar)}}" alt="" class="profile-img">
            <p class="profile-name text-center">{{$user->name}}</p>
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
                <img src="{{asset('/img/image/Component.png')}}" alt="">
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
            @yield('form')
        </div>
    </div>
</div>
@endsection