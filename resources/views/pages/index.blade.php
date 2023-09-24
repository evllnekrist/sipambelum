@extends('layouts.app-public')
@section('title', 'Home')
@section('content')
    <div id="main-wrapper">	
        <!-- start :: banner -->
        <div class="home-slider margin-bottom-0" id="bannerItemSlider">
            @if(@$banner)
            @foreach($banner as $item)
            <div data-background-image="{{$item->img_main}}" class="item home-slider-item-compact" id="bannerItemSlider_{{$item->id}}">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="home-slider-container">
                                <div class="home-slider-desc">
                                    <div class="home-slider-title">
                                        <h3>{{($item->title?$item->title:'')}}<span class="trans_text"></span></h3>
                                        <h5 class="offers_tags">{{($item->subtitle?$item->subtitle:'')}}</h5>
                                    </div>
                                    @if($item->button_title)
                                    <a href="{{$item->button_link}}" class="read-more theme-bg">{{$item->button_title}}<i class="fa fa-arrow-right ml-2"></i></a>`;
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
        <!-- end   :: banner -->
        <!-- start :: award  -->
        <section class="p-0">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                    
                        <div class="_awards_group">	
                            <ul class="_awards_lists four">
                                <!-- single list -->
                                <li>
                                    <div class="_awards_list_wrap">
                                        <div class="_awards_list_thumb op-1"><img src="assets/img/training.png" class="img-fluid" alt="" /></div>
                                        <div class="_awards_list_caption">
                                            <h5 id="count_training">..</h5>
                                            <span>Pelatihan</span>
                                        </div>
                                    </div>
                                </li>
                                <!-- single list -->
                                <li>
                                    <div class="_awards_list_wrap">
                                        <div class="_awards_list_thumb op-1"><img src="assets/img/award-2.png" class="img-fluid" alt="" /></div>
                                        <div class="_awards_list_caption">
                                            <h5 id="count_advance">..</h5>
                                            <span>Mahir</span>
                                        </div>
                                    </div>
                                </li>
                                <!-- single list -->
                                <li>
                                    <div class="_awards_list_wrap">
                                        <div class="_awards_list_thumb op-1"><img src="assets/img/award-4.png" class="img-fluid" alt="" /></div>
                                        <div class="_awards_list_caption">
                                            <h5 id="count_intermediate">..</h5>
                                            <span>Menengah</span>
                                        </div>
                                    </div>
                                </li>
                                <!-- single list -->
                                <li>
                                    <div class="_awards_list_wrap">
                                        <div class="_awards_list_thumb op-1"><img src="assets/img/award-4b.png" class="img-fluid" alt="" /></div>
                                        <div class="_awards_list_caption">
                                            <h5 id="count_beginner">..</h5>
                                            <span>Pemula</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                    </div>
                    <span id="statisticsHomepageInfo"></span>
                </div>
            </div>
        </section>
        <!-- end   :: award  -->
        <!-- start :: news   -->
        <section class="min">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="sec-heading center">
                            <h2>Berita Terbaru</h2>
                            <p>Informasi terkini terkait</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center" id="newsItemPreview">
                    <div class="mx-auto"><img src="{{asset('assets/img/loading.gif')}}"></div>
                </div>
                <div class="row justify-content-center">
                    <a href="{{route('user.news')}}" class="btn btn-theme-light-2 rounded">Tampilkan Lebih Banyak</a>
                </div>
            </div>
        </section>
        <!-- end   :: news   -->
        <!-- start :: training   -->
        <section class="image-cover" style="background:#0f161a url(assets/img/pattern.png) no-repeat;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="sec-heading center light">
                            <h2>Pelatihan Terbaru</h2>
                            <p>Daftar pelatihan terkini di Kabupaten Katingan</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center" id="trainingItemPreview">
                    <div class="mx-auto"><img src="{{asset('assets/img/loading-dark.gif')}}"></div>
                </div>
                <div class="row justify-content-center">
                    <a href="{{route('user.training')}}" class="btn btn-whites rounded">Tampilkan Lebih Banyak</a>
                </div>
            </div>
        </section>
        <!-- end   :: training   -->
        <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
    </div>
@endsection
@section('addition_script')
    <script src="{{ asset('assets/js/page.js').'?v=230924001' }}"></script>
    <script src="{{ asset('assets/js/user/home.js') }}"></script>
@endsection