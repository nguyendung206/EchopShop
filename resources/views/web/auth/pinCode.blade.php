@extends('web.auth.layout.blank')
@section('extra-css')
    <link rel="stylesheet" href="{{ asset('/css/authentic.css') }}">
@endsection
@section('content')
    <div class="login-page">
      <img class="background-1" src="{{ getImage(null,'b1.png') }}" alt="b1" />
      <img class="background-2" src="{{ getImage(null,'b2.png')}}" alt="b2" />
      <div class="content-wrap">
        <div class="row center-item">
          <div class="content-1">
            <div class="login-form" style="margin-top: -200px">
              <form action="{{route('web.pinCode', $token)}}" id="pinForm" method="POST">
                @csrf
                <div>
                  <img src="{{ getImage(null,'logo-2.png')}}" alt="logo" />
                </div>
                <div class="c-1-title">Xác thực email</div>
                <div class="c-1-label">
                  Chúng tôi đã gửi mã xác thực tới email {{$email}}. Vui
                  lòng nhập mã xác thực của bạn tại đây.
                </div>
                <div class="c-1-input row">
                  <div class="col-lg-2 col-2 auth">
                    <input class="pin-input" type="text" maxlength="1" name="pin1" id="pin1"/>
                  </div>
                  <div class="col-lg-2 col-2 auth"><input type="text" class="pin-input" maxlength="1" name="pin2" id="pin2"/></div>
                  <div class="col-lg-2 col-2 auth"><input type="text" class="pin-input" maxlength="1" name="pin3" id="pin3"/></div>
                  <div class="col-lg-2 col-2 auth"><input type="text" class="pin-input" maxlength="1" name="pin4" id="pin4"/></div>
                  <div class="col-lg-2 col-2 auth"><input type="text" class="pin-input" maxlength="1" name="pin5" id="pin5"/></div>
                  <div class="col-lg-2 col-2 auth"><input type="text" class="pin-input" maxlength="1" name="pin6" id="pin6"/></div>
                  <input type="hidden" name="pin" id="pin">
                  @if ($errors->any())
                    <div style="color: rgba(117,0,0,1);text-align: left; margin-bottom: 25px;padding-left: 15px;">
                          Vui lòng nhập mã pin gòm 6 ký tự.
                      </div>
                  @endif
                  @if(session('error'))
                      <div style="color: rgba(117,0,0,1);text-align: left; margin-bottom: 25px;padding-left: 15px;">
                          {{ session('error') }}
                      </div>
                  @endif
                </div>
                <div class="c-1-button"><button>Xác thực</button></div>
              </form>
            </div>
          </div>
          <div class="content-2 ">
            <img src="{{ getImage(null,'Untitled-2.png')}}" class="c-img-2" alt="" />
          </div>
        </div>
      </div>
    </div>

    <script>
      const inputs = document.querySelectorAll(".pin-input");

      inputs.forEach((input, index) => {
        input.addEventListener("input", (e) => {
          if (input.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus(); // Chuyển sang ô tiếp theo
          }
        });

        input.addEventListener("keydown", (e) => {
          if (e.key === "Backspace" && index > 0 && input.value.length === 0) {
            inputs[index - 1].focus(); // Quay lại ô trước đó khi nhấn Backspace
          }
        });
      });
    </script>

    <script>
        const form = document.querySelector("#pinForm");
        const pin1 = document.querySelector('#pin1');
        const pin2 = document.querySelector('#pin2');
        const pin3 = document.querySelector('#pin3');
        const pin4 = document.querySelector('#pin4');
        const pin5 = document.querySelector('#pin5');
        const pin6 = document.querySelector('#pin6');
        const pin = document.querySelector('#pin');

        form.addEventListener("submit", (e) => {
        let pinValue = pin1.value + pin2.value + pin3.value + pin4.value + pin5.value + pin6.value;
        pin.value = pinValue;
        });
    </script>
@endsection
