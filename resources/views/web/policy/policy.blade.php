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
        @switch(true)
            @case(stripos(request()->url(), 'security') !== false)
                Chính sách bảo mật
                @break
            @case(stripos(request()->url(), 'term') !== false)
                Điều khoản dịch vụ
                @break
            @case(stripos(request()->url(), 'prohibited') !== false)
                Hành vi bị cấm
                @break
            @case(stripos(request()->url(), 'communicate') !== false)
                Chính sách giao tiếp
                @break
            @case(stripos(request()->url(), 'safeToUse') !== false)
                Hướng dẫn an toàn sử dụng
                @break
            @default
                Chính sách
                @break
        @endswitch
    </div>
</div>
<div class="container content">
    <div class="row">
    @foreach ($policies as $policy)
    <div class="col-12"  style="font-size: 16px; margin: 20px 0;font-weight: 400;line-height: 18.75px;color:#535353;">{{$policy->description}}</div>
    @endforeach
</div>
</div>
@endsection