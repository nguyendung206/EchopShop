@extends('web.layout.app')
@section('title')
Chính sách
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('/css/product.css') }}">
@endsection
@section('content')
<div class="title-line">
    <div class="title-text">
        Liên hệ với chúng tôi
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-5 col-12 information-us" >
            <div class="wrap-us">
                <p class="title-us">Số điện thoại</p>
                <div class="content-us">
                    <img src="{{asset('img/image/phone-contact-us.png')}}" alt=""><span>001 234 567 890</span>
                </div>
            </div>
            <div class="wrap-us">
                <p class="title-us">Địa chỉ</p>
                <div  class="content-us">
                    <img src="{{asset('img/image/local-contact-us.png')}}" alt=""><span>Tầng 3 , căn SH49, tháp B, Manor Crown</span>
                </div>
            </div>
            <div class="wrap=us">
                <p class="title-us">Giờ làm việc</p>
                <div class="content-us">
                    <img src="{{asset('img/image/work-time.png')}}" alt=""> <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. </span>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-12 information-input" >
            <form action="{{route('about.contactUs')}}" method="POST" id="contactForm">
                @csrf
                <div>
                    <div class="wrap-input wrap-input-name">
                        <img src="{{asset('img/image/user-contact-us.png')}}" alt="" class="icon-user-input">
                        <input type="text" placeholder="Nhập tên của bạn"  class="input-user" name="name">
                    </div>
                    <div class="wrap-input wrap-input-email">
                        <img src="{{asset('img/image/sms-contact-us.png')}}" alt="" class="icon-sms-input">
                        <input type="text" placeholder="Nhập địa chỉ Email*" class="input-sms" name="email">
                    </div>
                    <div class="wrap-input-content">
                        <textarea type="text " placeholder="Nhập nội dung tin nhắn" class="input-content" name="content"></textarea>
                    </div>
                    <div  class="text-right wrap-button">
                        <a href="{{route('home')}}" class="all button-cancel">Huỷ</a>
                        <button class="buy button-send" type="submit">Gửi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@section('script')
<script>
$(document).ready(function() {
    $('#contactForm').on('submit', function(e) {
                e.preventDefault(); // Ngăn chặn gửi form mặc định

                var form = $(this);
                var formData = form.serialize();

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        $('.error-message').remove();
                            toastr.success(response.message, null, { positionClass: 'toast-bottom-left' });
                            form.trigger('reset'); // Reset form sau khi gửi thành công
                    },
                    error: function(xhr) {
                        $('.error-message').remove();
                        function showError(inputClass, fielName) {
                            if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.hasOwnProperty(fielName)) {
                                $(inputClass).after('<div class="error-message text-danger mt-3">' + xhr.responseJSON.errors[fielName][0] + '</div>');
                            }
                        }
                        showError('.wrap-input-name', 'name');
                        showError('.wrap-input-content', 'content');
                        showError('.wrap-input-email', 'email');
                        toastr.error('Đã xảy ra lỗi, vui lòng thử lại.', null, { positionClass: 'toast-bottom-left' });
                    }
                });
            });
});
</script>
@endsection
@endsection