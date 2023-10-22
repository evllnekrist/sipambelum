@extends('layouts.app')
@section('title', 'Pengguna')
@section('content')
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Pengguna</li>
        </ol>
      </div>
    </div>
  
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <div class="col-4">
              <a class="btn btn-theme-light-2 rounded" href="{{route('register')}}"><i class="fas fa-plus mr-2"></i>Tambah Baru</a>
            </div>
          </div>
          <div class="card-body">
            <table id="data-list" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width:100px!important" title="Profile Picture (Gambar Profil)">PP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td id="page-loading" colspan="7"></td></tr>
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('addition_script')
  <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{asset('assets/plugins/jszip/jszip.min.js')}}"></script>
  <script src="{{asset('assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
  <script src="{{asset('assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
  <script src="{{asset('assets/js/page.js')}}"></script>
  <script src="{{asset('assets/js/admin/register_index.js')}}"></script>
@endsection

@section('addition_css')
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection