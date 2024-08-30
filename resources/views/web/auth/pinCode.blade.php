<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Echop</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="{{ asset('/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/authentic.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Alatsi&family=Exo:ital,wght@0,100..900;1,100..900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <div class="login-page">
      <img class="background-1" src="{{ asset('/img/b1.png') }}" alt="b1" />
      <img class="background-2" src="{{ asset('/img/b2.png')}}" alt="b2" />
      <div class="content-wrap">
        <div class="row center-item">
          <div class="content-1">
            <div class="login-form" style="margin-top: -300px">
              <form action="{{route('web.pinCode', $token)}}" id="pinForm" method="POST">
                @csrf
                <div>
                  <img src="{{ asset('/img/logo-2.png')}}" alt="logo" />
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
            <img src="{{ asset('/img/Untitled-2.png')}}" class="c-img-2" alt="" />
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
  </body>
</html>
