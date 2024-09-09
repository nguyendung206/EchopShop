@extends('admin.layout.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Thông tin Banner')}}</h5>
    </div>
    <div class="card-body">
        <section class="vh-100" style="background-color: #f4f5f7;">
            <div class="container  h-100">
            <div class="row d-flex justify-content-center pt-5 h-100">
                <div class="col col-lg-6 mb-4 mb-lg-0">
                <div class="card mb-3" style="border-radius: .5rem;">
                    <div class="row g-0">
                        <div class="col-md-12 gradient-custom text-center text-white"
                        style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                        <img src="{{ getImage('upload/banners/',$banner->photo, 'nobanner.png')}}"
                        alt="Avatar" class="img-fluid my-5" style="width: 100%;" />
                        </div>
                    </div>
                    <div class="row g-0">
                    
                    <div class="col-md-12">
                        <div class="card-body p-4">
                        <h6>
                            {{$banner->title}}
                        </h6>
                        <hr class="mt-0 mb-4">
                        <div class="row pt-1">
                            <div class="col-6 mb-3">
                            <h6>Mô tả</h6>
                            <p class="text-muted">{{strip_tags($banner->description)}}</p>
                            </div>
                            <div class="col-6 mb-3">
                            <h6>Liên kết</h6>
                            <p class="text-muted">{{$banner->link}}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <h6>Trạng thái</h6>
                                <p class="text-muted">{{$banner->status->label()}}</p>
                                </div>
                        </div>
                        <div class="d-flex justify-content-start">
                            <a class="btn btn-primary" style="color: white" href="{{ route('banner.edit', $banner->id)}}">Sửa</a>
                            <form action="{{ route('banner.destroy', $banner->id)}}" method="POST"  style="display: inline-block;margin-bottom: 0px" id="delete-form">
                                @csrf
                                @method("DELETE")
                                <a href="javascript:void(0)" data-href="{{route('banner.destroy',$banner->id)}}" data-id="{{$banner->id}}" class="btn btn-delete  btn-danger confirm-delete" title="@lang('banner.delete')" >
                                    Xoá
                                </a>
                            </form>
                            <a class="btn btn-secondary" style="color: white" href="{{route("banner.index")}}">Trở về</a>
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

@section('script')
<script type="text/javascript">
    $(document).on('click', '.btn-delete', function() {
        console.log("Alo")
            let delete_id= $(this).attr('data-id');
            let delete_href = $(this).attr('data-href');
            Swal.fire({
                title: 'Xoá người dùng này',
                text: 'Bạn có muốn tiếp tục xoá',
                // icon: 'error',
                confirmButtonText: 'Tiếp tục',
                cancelButtonText: 'Huỷ',
                showCancelButton: true,
                showCloseButton: true,

            }).then((result) => {
                if (result.isConfirmed) {
                    let form = $('#delete-form');
                    form.attr('action', delete_href);
                    form.submit();
                }
            });
        });
</script>
@endsection