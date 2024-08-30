<div style="display: block;text-align: center;height: 200px">
        @csrf
        <h2 style="margin: 15px 0;color: rgba(117,0,0,1)">Lấy lại mật khẩu của bạn</h2>
        <strong>Mã pin của bạn: </strong><span style="color: rgba(117,0,0,1);font-weight: 700;">{{$pin}}</span>
        <div> Vui lòng vào <a href="{{route('web.pinAuthentication',  $token)}}" style="color: rgba(117,0,0,1);font-weight: 700;text-decoration: none;"> tại đây </a> xác nhận để tiếp tục</div>
</div>
