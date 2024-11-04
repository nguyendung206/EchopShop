@extends('web.layout.app')
@section('title')
    {{ TypeStaticContentEnums::from($type)->label() }}
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('/css/product.css') }}">
@endsection
@section('content')
    <div class="title-line">
        <div class="title-text">
            {{ TypeStaticContentEnums::from($type)->label() }}
        </div>
    </div>
    <div class="container content mw-1200">
        @if (TypeStaticContentEnums::FAQ->value != $type)
            <div class="row">
                @forelse ($contents as $content)
                <div class="col-12"
                style="font-size: 16px; margin: 20px 0;font-weight: 400;line-height: 18.75px;color:#535353;">
                {{ $content->description }}</div>
                @empty
                <div class="text-center w-100"
                style="font-size: 16px; margin: 20px 0;font-weight: 400;line-height: 18.75px;color:red;">Chưa có mô tả cho mục này</div>
                @endforelse
            </div>
        
        @else
            <div class="row">
                <div class="col-12 text-center">
                    <div style="margin: 60px 0px 37px 0px">
                        <img src="{{asset("/img/image/faq.png")}}" alt="" style="max-width: 100%">
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($contents as $content)
                    <div class="col-12">
                        <div class="content-title" style="color: #B10000;padding: 25px 44px;width: 100%; border-bottom: 1px solid #B10000">
                            <span>{{$content->title}}</span>
                            <span class="show-content" style="float: right"><i class="fa-solid fa-caret-down icon-open" data-id="{{$content->id}}"></i></span>
                        </div>
                        <div class="content-description content-{{$content->id}}"  style="padding: 40px 44px;display: none;">
                            {{$content->description}}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@section('script')
    <script>
        $(document).ready(function() {
            $('.show-content').click(function() {
                const title = $(this).closest('.content-title');
                const allTitle = $('.content-title');
                const icon = $(this).find('.icon-open');
                const allIcon = $('.icon-open');
                const id = icon.data('id');
                const allContent = $('.content-description');
                const content = $(`.content-${id}`);
                console.log(content);
                
                if (icon.hasClass('fa-caret-down')) {
                    allTitle.css({
                        'background-color': 'white',
                        'color': '#b10000'
                    })
                    title.css({
                        'background-color': '#B10000',
                        'color': 'white'
                    })
                    allContent.slideUp();
                    content.slideDown();
                    allIcon.removeClass('fa-caret-up').addClass('fa-caret-down');
                    icon.removeClass('fa-caret-down').addClass('fa-caret-up');

                } else {
                    allTitle.css({
                        'background-color': 'white',
                        'color': '#b10000'
                    })
                    content.slideUp();
                    icon.removeClass('fa-caret-up').addClass('fa-caret-down');
                }
            });
        });
    </script>
@endsection
@endsection
