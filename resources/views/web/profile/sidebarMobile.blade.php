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