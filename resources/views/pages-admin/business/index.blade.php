@extends('layouts.app')
@section('title', 'Business')
@section('content')
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Business</li>
        </ol>
      </div>
    </div>
  
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <div class="col-4">
              @if(in_array(Auth::user()->role,['70x7','opd','kec']))
              <a class="btn btn-theme-light-2 rounded" href="{{ route('admin.business.add') }}"><i class="fas fa-plus mr-2"></i>Tambah Baru</a>
              @endif
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="data-list" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Potensi Lokal</th>
                    <th>NIB</th>
                    <th>Nama</th>
                    <th>Karyawan</th>
                    <th>Nomor Telepon</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Kecamatan</th>
                   
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
  </div>

  <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <h6>Bisnis</h6>
              <p><strong>NIB:</strong> <span id="nib"></span></p>
              <p><strong>Potensi Lokal:</strong> <span id="local_potential"></span></p>
              <p><strong>Nama:</strong> <span id="name"></span></p>
              <p><strong>Nomor Telepon:</strong> <span id="phone"></span></p>
              <p><strong>Email:</strong> <span id="email"></span></p>
              <p><strong>Alamat:</strong> <span id="address"></span></p>
              <p><strong>Kecamatan:</strong> <span id="subdistrict"></span></p>
            </div>
            <div class="col-md-6">
              <h6>Detail Bisnis</h6>
              <p><strong>Tanggal Pendirian:</strong> <span id="date_of_establishment"></span></p>
              <p><strong>Modal Awal:</strong> <span id="initial_business_capital"></span></p>
              <p><strong>Pendapatan:</strong> <span id="revenue"></span></p>
              <p><strong>Digitalisasi:</strong> <span id="digitalization"></span></p>
              <p><strong>Jumlah Karyawan:</strong> <span id="employees_count"></span></p>
              <p><strong>Masalah Pengembangan:</strong> <span id="development_problems"></span></p>
              <p><strong>Kebutuhan Pelatihan:</strong> <span id="training_needs"></span></p>
              <p><strong>Transaksi Penjualan:</strong> <span id="is_sales_transaction"></span></p>
              <p><strong>Akses Pendanaan:</strong> <span id="is_access_to_funding"></span></p>
              <p><strong>Laporan Keuangan:</strong> <span id="is_financial_report"></span></p>
              <p><strong>Akun Bisnis:</strong> <span id="is_business_account"></span></p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Mapping Trainee to Business -->
<div class="modal fade" id="mapTraineeModal" tabindex="-1" role="dialog" aria-labelledby="mapTraineeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mapTraineeModalLabel">Mapping Trainee to Business</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="mapTraineeForm">
      @csrf <!-- Ini akan memasukkan token CSRF ke dalam formulir -->
          <div class="form-group">
            <label for="traineeList">Select Trainee(s)</label>
            <div id="traineeList">
        

            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Map Trainee(s)</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection

@section('addition_script')
  <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
  <script src="{{ asset('assets/js/page.js') }}"></script>
  <script src="{{ asset('assets/js/admin/business_index.js') }}"></script>
@endsection

@section('addition_css')
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
