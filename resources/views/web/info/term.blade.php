@extends('web.layout.app')
@section('title')
ABOUT
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('/css/product.css') }}">
@endsection
@section('content')
<div class="title-line">
    <div class="title-text">Điều khoản dịch vụ</div>
</div>
<div class="container content">
    <div class="row">
    @foreach ($policies as $term)
    <div class="col-12"  style="font-size: 16px; margin: 20px 0;font-weight: 400;line-height: 18.75px;color:#535353;">{{$term->description}}</div>
    @endforeach
</div>
</div>
@endsection