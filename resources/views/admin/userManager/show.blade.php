@extends('admin.layout.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Thông tin người dùng')}}</h5>
    </div>
    <div class="card-body">
        <section class="vh-100" style="background-color: #f4f5f7;">
            <div class="container  h-100">
            <div class="row d-flex justify-content-center pt-5 h-100">
                <div class="col col-lg-6 mb-4 mb-lg-0">
                <div class="card mb-3" style="border-radius: .5rem;">
                    <div class="row g-0">
                    <div class="col-md-4 gradient-custom text-center text-white"
                        style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                        <img src="{{ asset('storage/upload/users/' . ($user->avatar ?? 'nophoto.png')) }}"
                        alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                    </div>
                    <div class="col-md-8">
                        <div class="card-body p-4">
                        <h6>
                            {{$user->name}}
                        </h6>
                        <hr class="mt-0 mb-4">
                        <div class="row pt-1">
                            <div class="col-6 mb-3">
                            <h6>Email</h6>
                            <p class="text-muted">{{$user->email}}</p>
                            </div>
                            <div class="col-6 mb-3">
                            <h6>Số điện thoại</h6>
                            <p class="text-muted">{{$user->phone_number}}</p>
                            </div>
                            
                        </div>
                        <div class="row pt-1">
                            <div class="col-6 mb-3">
                            <h6>Địa chỉ</h6>
                            <p class="text-muted">{{$user->address}}</p>
                            </div>
                            <div class="col-6 mb-3">
                            <h6>Ngày sinh</h6>
                            <p class="text-muted">{{ date('d/m/Y', strtotime(optional($user)->date_of_birth)) }}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <h6>Giới tính</h6>
                                <p class="text-muted">{{ App\Enums\UserGender::getKey($user->gender) == 'Male' ? 'Nam' : 'Nữ' }}</p>
                            </div>
                        </div>
                        <hr class="mt-0 mb-4">
                        <div class="row pt-1">
                            <div class="col-12 mb-3">
                            <h6>Căn cước công dân</h6>
                            <p class="text-muted">{{$user->citizen_identification_number}}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <h6>Nơi cấp</h6>
                                <p class="text-muted">{{$user->place_of_issue}}</p>
                                </div>
                                <div class="col-6 mb-3">
                                <h6>Ngày cấp</h6>
                                <p class="text-muted">{{date('d/m/Y', strtotime(optional($user)->date_of_issue))}}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <h6>Trạng thái tài khoản</h6>
                                    <p class="text-muted">{{App\Enums\UserStatus::getKey($user->status) == 'Active' ? 'Đang hoạt động' : 'Đã bị khoá'}}</p>
                                </div>
                        </div>
                        <div class="d-flex justify-content-start">
                            <a class="btn btn-primary" style="color: white" href="{{ route('manager-user.edit', $user->id)}}">Sửa</a>
                            <form action="{{ route('manager-user.destroy', $user->id)}}" method="POST"  style="display: inline-block;margin-bottom: 0px" id="delete-form">
                                @csrf
                                @method("DELETE")
                                <a href="javascript:void(0)" data-href="{{route('manager-user.destroy',$user->id)}}" data-id="{{$user->id}}" class="btn btn-delete  btn-danger confirm-delete" title="@lang('user.delete')" >
                                    Xoá
                                </a>
                            </form>
                            <a class="btn btn-secondary" style="color: white" href="{{route("manager-user.index")}}">Trở về</a>
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

















