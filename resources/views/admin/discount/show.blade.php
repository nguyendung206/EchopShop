@extends('admin.layout.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Thông tin Giảm giá')}}</h5>
    </div>
    <div class="card-body">
        <section class="vh-100" style="background-color: #f4f5f7;">
            <div class="container  h-100">
            <div class="row d-flex justify-content-center pt-5 h-100">
                <div class="col col-lg-6 mb-4 mb-lg-0">
                <div class="card mb-3" style="border-radius: .5rem;">
                    <div class="row g-0">
                    
                    <div class="col-md-12">
                        <div class="card-body p-4">
                        <h6>
                            {{$discount->title}}
                        </h6>
                        <hr class="mt-0 mb-4">
                        <div class="row pt-1">
                            <div class="col-12 mb-3">
                            <h6>Mô tả</h6>
                            <p class="text-muted">{{strip_tags($discount->description)}}</p>
                            </div>
                            <div class="col-6 mb-3">
                            <h6>Giá trị</h6>
                            <p class="text-muted">
                                {{$discount->type == TypeDiscountEnums::PERCENT ? $discount->value : number_format($discount->value, 0)}}
                                    @if ($discount->type == TypeDiscountEnums::PERCENT)
                                    %
                                    @else
                                    VNĐ 
                                    @endif
                            </p>
                            </div>
                            <div class="col-6 mb-3">
                                <h6>Ngày bắt đầu</h6>
                                <p class="text-muted">{{$discount->start_date}}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <h6>Ngày kết thúc</h6>
                                <p class="text-muted">{{$discount->end_date}}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <h6>Số lượng</h6>
                                <p class="text-muted">{{$discount->max_uses}}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <h6>Giới hạn số lần sử dụng</h6>
                                <p class="text-muted">{{$discount->limit_uses}}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <h6>Số mã đã được dùng</h6>
                                <p class="text-muted">{{$discount->current_uses}}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start">
                            <a class="btn btn-primary" style="color: white" href="{{ route('admin.discount.edit', $discount->id)}}">Sửa</a>
                            <a class="btn btn-secondary" style="color: white" href="{{route("admin.discount.index")}}">Trở về</a>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </section>
    </div>
</div>
@endsection

