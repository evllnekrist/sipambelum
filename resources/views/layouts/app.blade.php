<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="author" content="Erwin Syahrudin, Evelline Krist.">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>@yield('title') | Sipambelum Katingan</title>
      <link rel="icon" type="image/x-icon" href="{{asset('logo-katingan.png')}}">
      <link rel="stylesheet" href="{{asset('assets/css/styles.css').'?v='.date('YmdH')}}">
      <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert2/sweetalert2.min.css')}}">
      @yield('addition_css')
    </head>
    <body class="yellow-skin @yield('body-class')">
      @include('includes.nav-public')
        <div class="preloader"></div>
        <div id="main-wrapper">
            <section class="gray pt-5 pb-5">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-sm-4">
                            @include('includes.nav')
                        </div>
						<div class="col-lg-10 col-md-9 col-sm-6">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </section>	
        </div>
        @include('includes.footer')
        <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
        <script>
            const assetUrl = "{{asset('/')}}"
        </script>
        <script src="{{asset('assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/js/popper.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/ion.rangeSlider.min.js')}}"></script>
        <script src="{{asset('assets/js/select2.min.js')}}"></script>
        <script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
        <script src="{{asset('assets/js/slick.js')}}"></script>
        <script src="{{asset('assets/js/slider-bg.js')}}"></script>
        <script src="{{asset('assets/js/lightbox.js')}}"></script> 
        <script src="{{asset('assets/js/imagesloaded.js')}}"></script>
        <script src="{{asset('assets/js/daterangepicker.js')}}"></script>
        <script src="{{asset('assets/js/custom.js')}}"></script>
        <script src="{{asset('assets/js/axios.min.js')}}"></script>
        <script src="{{asset('assets/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
        <script src="{{asset('assets/plugins/moment/moment-with-locales.min.js')}}"></script>
        @yield('addition_script')
	</body>
</html>
