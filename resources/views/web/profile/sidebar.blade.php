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