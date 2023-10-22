@extends('layouts.app')
@section('title', 'Admin')
@section('content')	
    <video width="100%" controls="controls" preload="none" autoplay="autoplay" muted loop="true" src="{{ asset('assets/video/bg-admin.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
@endsection
@section('addition_script')
    <script src="{{ asset('assets/js/page.js').'?v=230924001' }}"></script>
@endsection