<div class="col-lg-3 profile-list">
    <img src="{{ getImage(optional(Auth::user())->avatar) }}" alt="" class="profile-img">
    <p class="profile-name text-center">{{ optional(Auth::user())->name }}</p>
    <a class="profile-update-btn text-center">
        <i class="fa-regular fa-pen-to-square"></i>
        Chỉnh sửa
    </a>
    <ul class="list">
        <a href="{{route('web.profile.index', Session::get('user')->id)}} data-tab="profile">
            <i class="fa-regular fa-circle-user mr-1"></i>
            Hồ sơ của tôi
        </a>
        <a href="#" data-tab="orders">
            <i class="fa-solid fa-cart-plus mr-1"></i>
            Đơn hàng của tôi
        </a>
        <a href="#" data-tab="chat">
            <i class="fa-regular fa-comment-dots mr-1"></i>
            Lịch sử chat
        </a>
        <a href="#" data-tab="posts">
            <i class="fa-regular fa-file-lines mr-1"></i>
            Quản lý bài đăng
        </a>
        <a href="{{route('web.registershop.create')}}" data-tab="shop">
            <i class="fa-solid fa-store"></i>
            Đăng ký bán hàng
        </a>
        <a href="#" data-tab="favorites">
            <i class="fa-regular fa-heart mr-1"></i>
            Đã thích
        </a>
    </ul>
</div>