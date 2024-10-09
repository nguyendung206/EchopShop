<div class="col-lg-3 profile-list">
    <img src="{{ getImage(optional(Auth::user())->avatar) }}" alt="" class="profile-img profile-img-2">
    <p class="profile-name text-center">{{ optional(Auth::user())->name }}</p>
    @if (strpos(request()->url(), 'profile') == false)
    <a href="{{ route('profile.index', Session::get('user')->id) }}" class="buy change-profile-btn">
        <img src="{{ asset('/img/icon/edit-profile.png') }}" alt=""> Chỉnh sửa
    </a>
    @endif
    <ul class="list">
        <a href="{{route('profile.index', Session::get('user')->id)}}" class="profile-tab" data-tab="profile">
            <i class="fa-regular fa-circle-user mr-1"></i>
            Hồ sơ của tôi
        </a>
        <a href="{{route('purchase')}}" class="profile-tab" data-tab="orders">
            <i class="fa-solid fa-cart-plus mr-1"></i>
            Đơn hàng của tôi
        </a>
        <a href="#" class="profile-tab" data-tab="chat">
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
        <a href="{{route('favoriteProduct')}}" class="profile-tab" data-tab="favoriteProduct">
            <i class="fa-regular fa-heart mr-1"></i>
            Đã thích
        </a>
        <a href="{{route('notification.index')}}" class="profile-tab" data-tab="notifications">
            <i class="fa-regular fa-bell mr-1"></i>
            Thông báo
        </a>
    </ul>
</div>