<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>@yield('title')</title>
=======
    <title>Profile</title>
>>>>>>> main
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&family=Alatsi&display=swap"
        rel="stylesheet">
<<<<<<< HEAD
    <link rel="stylesheet" href="{{ asset('/css/resetcss.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
</head>
<body id="body">
    @include('web.layout.header')
    @yield('content')
    @include('web.layout.footer')
    
=======
    <link rel="stylesheet" href="{{ static_asset('css/resetcss.css') }}">
    <link rel="stylesheet" href="{{ static_asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ static_asset('css/profile.css') }}">
</head>

<body id="body">

    @include('web.inc.header')

    @yield('content')
    
    @include('web.inc.footer')

>>>>>>> main
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
<<<<<<< HEAD
    @yield('script')


    
=======
    <script src="{{ asset('js/text.js') }}"></script>
>>>>>>> main
</body>

</html>