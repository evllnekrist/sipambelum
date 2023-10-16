@extends('layouts.app-public')
@section('title', 'Tentang Kami')
@section('content')
    <div class="container" id="main-wrapper">	
        @if($selected->img_main)
        <div class="col-xl-12 col-lg-12 col-md-12 mb-5">
            <div class="text-center">
            <img src="{{$selected->img_main}}" class="img-fluid"/>
            </div>
        </div>
        @endif
        {!! $selected['body'] !!}
        <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
    </div>
@endsection
@section('addition_script')
@endsection