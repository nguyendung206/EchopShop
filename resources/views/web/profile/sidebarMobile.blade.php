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
                        <a href="{{route('profile.index', Session::get('user')->id)}}" data-tab="profile">
                            <i class="fa-regular fa-circle-user mr-1"></i>
                            Hồ sơ của tôi
                        </a>
                        <a href="{{route('profile.address')}}" class="profile-tab" data-tab="address">
                            <i class="fa-solid fa-location-arrow mr-1"></i>
                            Địa chỉ
                        </a>
                        <a href="{{route('order.show')}}" class="profile-tab" data-tab="orders-show">
                            <i class="fa-solid fa-bag-shopping mr-1"></i>
                            Đơn hàng của tôi
                        </a>
                        <a href="{{route('purchase')}}" class="profile-tab" data-tab="orders">
                            <i class="fa-regular fa-money-bill-1"></i>
                            Hóa đơn
                        </a>
                        <a href="#" data-tab="chat">
                            <i class="fa-regular fa-comment-dots mr-1"></i>
                            Lịch sử chat
                        </a>
                        @if(isset(optional(Auth::user()->shop)->status->value) && optional(Auth::user()->shop)->status->value === 1)
                        <a href="{{ route('post.index') }}" class="profile-tab" data-tab="posts">
                            <i class="fa-regular fa-file-lines mr-1"></i>
                            Quản lý bài đăng
                        </a>
                        @else
                        <a href="{{route('registershop.create')}}" class="profile-tab" data-tab="shop">
                            <i class="fa-solid fa-store"></i>
                            Đăng ký bán hàng
                        </a>
                        @endif
                        <a href="{{route('favoriteProduct')}}" data-tab="favoriteProduct">
                            <i class="fa-regular fa-heart mr-1"></i>
                            Đã thích
                        </a>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>