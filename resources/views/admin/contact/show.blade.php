@extends('admin.layout.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Thông tin Liên hệ')}}</h5>
    </div>
    <div class="card-body">
        <section class="vh-100" style="background-color: #f4f5f7;">
            <div class="container  h-100">
                <div class="row d-flex justify-content-center pt-5 h-100">
                    <div class="col col-lg-12 mb-4 mb-lg-0">
                        <div class="mb-3 row" style="border-radius: .5rem; padding-left:10px;padding-right: 10px;">
                            <div class="card col-md-6">
                                <div class="card-body p-4">
                                    <h5>
                                        Tên người gửi: {{$contact->name}}
                                    </h5>
                                    <h6>
                                        Email: {{$contact->email}}
                                    </h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-12 mb-3">
                                        <h6>Nội dung</h6>
                                        <p class="text-muted">{{strip_tags($contact->content)}}</p>
                                        </div>       
                                    </div>
                                    
                                </div>
                            </div>

                            <div class=" card col-md-6">
                                <form action="{{route('admin.contact.sendMail')}}" method="POST" id="contact-form">
                                    @csrf
                                    <div class="card-body p-4">
                                        <h5>
                                            Phản hồi
                                        </h5>
                                        <h6>
                                            echo@gmail.com
                                        </h6>
                                        <p class="text-muted">Tin nhắn sẽ được gửi vào mail của người liên hệ</p>
                                        <hr class="mt-0 mb-4">
                                        <div class="row pt-1">
                                            <div class="col-12 mb-3">
                                                <h6>Nội dung</h6>
                                                <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror">{{ old('content') }}
                                                </textarea>
                                                    @error('content')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                            </div>

                                        </div>     
                                        <input type="hidden" value="{{$contact->email}}" name="email">
                                        <input type="hidden" value="{{$contact->content}}" name="contentUser">
                                        <input type="hidden" value="{{$contact->id}}" name="id">
                                        <div class="d-flex justify-content-end">
                                            <a class="btn btn-secondary" style="color: white;margin-right: 20px;" href="{{route("admin.contact.index")}}">Trở về</a>
                                            <button class="btn btn-primary btn-submit" style="color: white" type="submit">Gửi</button>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection

