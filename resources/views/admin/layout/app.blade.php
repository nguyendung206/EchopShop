<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta name="file-base-url" content="{{ getFileBaseURL() }}">
    <meta name="robots" content="none">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="icon" href="{{ url('assets/img/pukcom.png') }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- google font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@1.8.3/dist/css/lightgallery.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- aiz core css -->
    <link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
    <link rel="stylesheet" href="{{ static_asset('assets/css/aiz-core.css') }}">
    <link rel="stylesheet" href="{{ static_asset('assets/css/custom-style.css?v=' . time()) }}">
    <style>
        body {
            font-size: 12px;
        }

        .load-wrapp {
           float: left;
            width: 100px;
            height: 100px;
            margin: 0 10px 10px 0;
            padding: 20px 20px 20px;
            border-radius: 5px;
            text-align: center;
            background-color: black;
            position: fixed;
            z-index: -1;
            top: 0;
            left: 0;
            width: 100vw;
            opacity: 0;
            
            height: 100vh;
        }
        .load-wrapp.active {
            opacity: 0.5;
            z-index: 99;


        }

        .line {
            display: inline-block;
            width: 15px;
            height: 15px;
            border-radius: 15px;
            background-color: #fff;
        }

          .load-wrapp .load-3 {
                transform: translate(-50%, -50%);
                margin: auto;
                position: absolute;
                top: 50%;
                left: 50%;
          }

        .load-3 .line:nth-last-child(1) {
            animation: loadingC 0.6s 0.1s linear infinite;
        }

        .load-3 .line:nth-last-child(2) {
            animation: loadingC 0.6s 0.2s linear infinite;
        }

        .load-3 .line:nth-last-child(3) {
            animation: loadingC 0.6s 0.3s linear infinite;
        }

        @keyframes loadingC {
            0 {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(0, 15px);
            }

            100% {
                transform: translate(0, 0);
            }
        }
    </style>

    @yield('style')

    <script>
        var AIZ = AIZ || {};
        AIZ.local = {
            nothing_found: '{{ trans('base.nothing_found') }}',
            choose_file: '{{ translate('Choose file') }}',
            file_selected: '{{ translate('File selected') }}',
            files_selected: '{{ translate('Files selected') }}',
            add_more_files: '{{ translate('Add more files') }}',
            adding_more_files: '{{ translate('Adding more files') }}',
            drop_files_here_paste_or: '{{ translate('Drop files here, paste or') }}',
            browse: '{{ translate('Browse') }}',
            upload_complete: '{{ translate('Upload complete') }}',
            upload_paused: '{{ translate('Upload paused') }}',
            resume_upload: '{{ translate('Resume upload') }}',
            pause_upload: '{{ translate('Pause upload') }}',
            retry_upload: '{{ translate('Retry upload') }}',
            cancel_upload: '{{ translate('Cancel upload') }}',
            uploading: '{{ translate('Uploading') }}',
            processing: '{{ translate('Processing') }}',
            complete: '{{ translate('Complete') }}',
            file: '{{ translate('File') }}',
            files: '{{ translate('Files') }}',
        }
    </script>

</head>

<body class="">
   
    @if (session()->has('flash_notification'))
        <div class="flash-message {{ session('flash_notification.class') }}">
            {{ session('flash_notification.message') }}
        </div>
    @endif

 <div class="load-wrapp" id="loadPage">
        <div class="load-3">

            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </div>

    <div class="aiz-main-wrapper">
        @include('admin.inc.admin_sidenav')
        <div class="aiz-content-wrapper">
            @include('admin.inc.admin_nav')
            <div class="aiz-main-content">
                <div class="px-15px px-lg-25px">
                    @yield('content')
                </div>
                <div class="bg-white text-center py-3 px-15px px-lg-25px mt-auto">
                    <p class="mb-0">&copy; Pukcom</p>
                </div>
            </div><!-- .aiz-main-content -->
        </div><!-- .aiz-content-wrapper -->
    </div><!-- .aiz-main-wrapper -->
    
    @yield('modal')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"
        integrity="sha256-ErZ09KkZnzjpqcane4SCyyHsKAXMvID9/xwbl/Aq1pc=" crossorigin="anonymous"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" ></script> --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('assets/js/vendors-admin.js') }}"></script>
    <script src="{{ asset('assets/js/summernote-image-title.js') }}"></script>
    <script src="{{ asset('js/aiz-core-admin.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.3.2/js/lightgallery.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    @yield('script')


    <script type="text/javascript">
        @foreach (session('flash_notification', collect())->toArray() as $message)
            AIZ.plugins.notify('{{ $message['level'] }}', '{{ $message['message'] }}');
        @endforeach
    </script>
</body>

</html>
