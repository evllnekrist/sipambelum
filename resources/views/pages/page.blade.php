@extends('layouts.app-public')
@section('title', $page->title) <!-- Menetapkan judul halaman -->
@section('content')

<div id="main-wrapper">	
    <section>
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="eplios_tags">
                        <h2>{{ $page->title }}</h2>
                        {!! $page->body !!}
                    </div>
                </div>
                
                <div class="col-xl-5 col-lg-5 col-md-6 col-sm-12">
                    <div class="text-center">
                        @if($page->img_main)
                            <img src="{{ asset($page->img_main) }}" class="img-fluid" alt="">
                        @else
                            <p>Gambar tidak tersedia</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <a id="back2Top" class="top-scroll" title="Back to top" href="#" style="display: none;"><i class="ti-arrow-up"></i></a>
</div>

@endsection

@section('addition_script')
    <!-- Script tambahan jika diperlukan -->
    <script src="{{ asset('assets/js/page.js') }}"></script>
    <script src="{{ asset('assets/js/user/home.js') }}"></script>
@endsection
