@extends('layouts.app')
@section('title', '404')
@section('content')
<div class="wrapper">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>404 Error Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item active">Error</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="error-page row">
        <div class="col-4">
          <img src="{{asset('assets/img/404_enggang.png')}}" class="img-fluid" alt="">
        </div>
        <div class="col-8">
          <p>
            <h3 class="text-warning">Oops...</h3>
            {{@$desc}}<br>
            <small>Klik <a href="{{route('admin.dashboard')}}">disini</a> untuk kembali ke dashboard.</small>
          </p>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection

@section('addition_script')
@endsection
@section('addition_css')
@endsection