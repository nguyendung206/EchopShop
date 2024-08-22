@extends('admin.layout.app')

@section('content')
<div class="row gutters-10 chart">
    <div class="col-md-12">
        <div class="card" style="border-radius: 10px">
            <div class="tab-content" id="pills-tabContent">
                <section class="vh-100" style="background-color: #f4f5f7;">
                    <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
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
                                    <h6>Phone</h6>
                                    <p class="text-muted">{{$user->phone_number}}</p>
                                    </div>
                                </div>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                    <div class="col-6 mb-3">
                                    <h6>Địa chỉ</h6>
                                    <p class="text-muted">{{$user->address}}</p>
                                    </div>
                                    <div class="col-6 mb-3">
                                    <h6>Email</h6>
                                    <p class="text-muted">{{$user->email}}</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start">
                                    <a class="btn btn-primary" style="color: white" href="/admin/update-user/{{$user->id}}">Sửa</a>
                                    <form action="/admin/delete-user/{{$user->id}}" method="POST"  style="display: inline-block; margin-bottom: 0">
                                        @csrf
                                        @method("DELETE")
                                        <button class="btn btn-danger" type="submit">Xoá</button>
                                    </form>
                                    <a class="btn btn-secondary" style="color: white" href="/admin/list-users">Trở về</a>
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
</div>
</div>



