@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <div id="main-wrapper">	
      <!-- start :: banner -->
      <div class="home-slider margin-bottom-0" id="bannerItemSlider">
        @if(@$banner)
        @foreach($banner as $item)
        <div data-background-image="{{$item->img_main}}" class="item">
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
			<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
		</div>
@endsection
@section('addition_script')
    <script src="{{ asset('assets/js/page.js') }}"></script>
    <script src="{{ asset('assets/js/user/home.js') }}"></script>
@endsection