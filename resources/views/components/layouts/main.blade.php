<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <title>{{ $company->name }}</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    {{-- AOS CSS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/swiper.css') }}">

</head>
<body>
    <x-layouts.navbar/>
   
    {{ $slot }}

    <a href="#" id="backToTopBtn" class="back-to-top fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-gray-500 hover:bg-gray-400 text-white py-2 px-4 z-50 rounded-full hidden">Back to Top</a>
    
    <x-layouts.footer/>

    {{-- AOS JS --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    <script src="{{ asset('js/swiper.js') }}"></script>

    {{-- Back to Top JS --}}
    <script src="{{ asset('js/backToTop.js') }}"></script>
</body>
</html>