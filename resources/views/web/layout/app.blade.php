<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&family=Alatsi&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/css/resetcss.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    @yield('css')
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
</head>
<style>
    /* Tùy chỉnh phong cách của Toastr */
    .toast {
        border-radius: 8px;
        background-color: #333;
        color: #fff;
        position: relative;
        padding: 15px 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .toast-success {
        background-color: #28a745;
    }

    .toast-error {
        background-color: #dc3545;
    }

    .toast-info {
        background-color: #17a2b8;
    }

    .toast-warning {
        background-color: #ffc107;
    }

    .toast-title {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .toast-message {
        line-height: 1.5;
    }

    .toast-close-button {
        position: absolute;
        top: 20px;
        right: 10px;
        background: none;
        border: none;
        color: #fff;
        font-size: 18px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .toast-close-button:hover {
        color: #ddd;
    }

    .ck-content {
        height: 200px;
    }

    .ck p {
        margin: 0;
    }

    .btn-product {
        color: #535353;
        font-size: 16px;
    }

    .list-star .rating-active {
        color: #FCC500;
    }
</style>

<body id="body">

    @include('web.inc.header')
    <div class="pt-200 pt-120">
        @yield('content')
    </div>
    @include('web.inc.footer')


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script src="{{asset('/js/text.js')}}"></script>
    @yield('script')

    <script>
        // Toastr configuration with close button
        @if(session('success'))
        toastr.success("{{ session('success') }}", null, {
            positionClass: 'toast-bottom-left',
            timeOut: 5000
        });
        @elseif(session('error'))
        toastr.error("{{ session('error') }}", null, {
            positionClass: 'toast-bottom-left',
            timeOut: 5000
        });
        @elseif(session('info'))
        toastr.info("{{ session('info') }}", null, {
            positionClass: 'toast-bottom-left',
            timeOut: 5000
        });
        @elseif(session('warning'))
        toastr.warning("{{ session('warning') }}", null, {
            positionClass: 'toast-bottom-left',
            timeOut: 5000
        });
        @endif
    </script>
    <script>
        $('.dropdown-submenu').hover(function() {
            $(this).children('.dropdown-menu').stop(true, true).slideDown(200);
        }, function() {
            $(this).children('.dropdown-menu').stop(true, true).slideUp(200);
        });
    </script>
</body>

</html>