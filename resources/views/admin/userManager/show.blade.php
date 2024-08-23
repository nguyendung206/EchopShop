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
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
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
                            <p class="text-muted">{{ \DateTime::createFromFormat('Y-m-d H:i:s', $user->date_of_birth)->format('d/m/Y');}}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <h6>Giới tính</h6>
                                <p class="text-muted">{{$user->gender == 0 ? "Nam" : "Nữ"}}</p>
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
                                <p class="text-muted">{{ \DateTime::createFromFormat('Y-m-d H:i:s', $user->day_of_issue)->format('d/m/Y');}}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <h6>Trạng thái tài khoản</h6>
                                    <p class="text-muted">{{$user->status == 0 ? "Đang hoạt động" : "Đã bị khoá"}}</p>
                                </div>
                        </div>
                        <div class="d-flex justify-content-start">
                            <a class="btn btn-primary" style="color: white" href="{{ route('manager-user.edit', $user->id)}}">Sửa</a>
                            
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

<script>
    $(document).on('click', '.btn-delete', function() {
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
                    var data = {
                        "_token": "{{ csrf_token() }}",
                        "id": delete_id,
                    };
                    $.ajax({
                        type: "DELETE",
                        url: delete_href,
                        data: data,
                        success: function (response){
                            Swal.fire('Xoá thành công');
                            location.reload();
                        },
                        error : function(err) {
                            console.log(err.responseText);
                            Swal.fire('Đã có lỗi xảy ra');
                        }
                    });
                }
            });
        });
</script>
@endsection

















