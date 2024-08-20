@extends('admin.layout.app')
<title>Profile</title>
@section('content')
<div class="box box-primary">
    <div class="box-body">
        <form action="{{route('profile.save')}}" method="post" enctype="multipart/form-data">
            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
            <!-- @if (flash()->message)
            <div class="{{ flash()->class }} alert alert-success">
                {{ flash()->message }}
            </div>

            @if(flash()->level === 'error')
            This was an error.
            @endif
            @endif -->
            <input type="hidden" name="Id" value="{{$profile->id}}" />
            <input type="hidden" name="Password" value="{{$profile->Password}}" />
            <div class="form-group">
                <label>Tên:</label>
                <input type="text" class="form-control" name="Name" value="{{$profile->name}}">
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" class="form-control" name="Email" value="{{$profile->email}}">
            </div>
            <div class="form-group">
                <label>Chức vụ:</label>
                <input type="text" class="form-control" name="Role" value="{{$profile->role}}" readonly>
            </div>
            <div class="form-group">
                <label>Trạng thái:</label>
                <input type="text" class="form-control" name="Status" value="{{$profile->status}}" readonly>
            </div>
            <div class="form-group">
                <label>Ảnh đại diện:</label>
                <input type="hidden" name="Avatar" value="{{$profile->avatar}}" />
                <input type="file" class="form-control" name="uploadPhoto" onchange="document.getElementById('Photo').src = window.URL.createObjectURL(this.files[0])" />
            </div>
            <div class="form-group">
                <img id="Photo" src="{{ asset('upload/employee/' . ($profile->avatar ?? 'nophoto.png')) }}" class="img img-bordered" style="width:200px" />
            </div>


            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-floppy-o"></i>
                    Lưu dữ liệu
                </button>
                <a href="{{route('admin.index')}}" class="btn btn-default">Quay lại</a>
            </div>
            @csrf
        </form>
    </div>
</div>
@endsection