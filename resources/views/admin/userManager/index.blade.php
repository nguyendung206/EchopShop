@extends('admin.layout.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Danh sách người dùng')}}</h5>
    </div>
    <div class="card-body">
        <div><a class="btn btn-primary" style="color: white" href="{{ route("manager-user.create") }}">Thêm người dùng</a></div>
@if (session('message'))
    <div style="color: red;">
        {{ session('message') }}
    </div>
@endif
<table class="table">
    <thead>
      <tr>
        <th scope="col">STT</th>
        <th scope="col">Tên người dùng</th>
        <th scope="col">Email</th>
        <th scope="col">Địa chỉ</th>
        <th scope="col">Tuỳ chọn</th>
      </tr>
    </thead>
    <tbody>
     @for ($i = 0 ; $i < count($users); $i++)
     <tr>
        <th scope="row">{{$i+1;}}</th>
        <td>{{$users[$i]->name}}</td>
        <td>{{$users[$i]->email}}</td>
        <td>{{$users[$i]->address}}</td>
        <td>
            <a class="btn btn-primary" style="color: white" href="{{ route("manager-user.show", $users[$i]->id)}}">Xem</a>
            <a class="btn btn-primary" style="color: white" href="{{ route("manager-user.edit", $users[$i]->id)}}">Sửa</a>
            <form action="{{ route('manager-user.destroy', $users[$i]->id)}}" method="POST"  style="display: inline-block">
                @csrf
                @method("DELETE")
                <button class="btn btn-danger" type="submit">Xoá</button>
            </form>
        </td>
      </tr>
     @endfor
    </tbody>
  </table>
        {{-- <div class="aiz-pagination">
            {{ $products->withQueryString()->links() }}
        </div> --}}
    </div>
</div>

@endsection


















