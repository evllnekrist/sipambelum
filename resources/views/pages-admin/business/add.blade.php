@extends('layouts.app')
@section('title', 'Business')
@section('content')
<div class="content-wrapper">
  @include('includes.loading')
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="text-muted2">Tambah Baru</h5>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" target="_blank">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.business') }}" target="_blank">Business</a></li>
          <li class="breadcrumb-item active">Tambah</li>
        </ol>
      </div>
    </div>
    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <div class="card card-primary">
          <div class="card-header">
            <h6 class="card-title text-muted2">Business</h6>
          </div>
          <div class="card-body">
            <form method="post" action="#" id="form">
              <!-- Local Potential -->
            <div class="form-group">
              <label>Potensi Lokal <code>*</code></label>
              <select class="form-control form-control-border border-width-2" name="id_local_potential" id="id_local_potential" required>
                <option value="">Pilih Potensi Lokal</option>
                @foreach($localPotentials as $localPotential)
                  <option value="{{ $localPotential->id }}">{{ $localPotential->name }}</option>
                @endforeach
              </select>
            </div>
              <!-- NIB -->
              <div class="form-group">
                <label>NIB <code>*</code></label>
                <input type="text" name="nib" class="form-control form-control-border border-width-2" required>
              </div>

              <!-- Nama -->
              <div class="form-group">
                <label>Nama <code>*</code></label>
                <input type="text" name="name" class="form-control form-control-border border-width-2" required>
              </div>

              <!-- Nomor Telepon -->
              <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="text" name="phone" class="form-control form-control-border border-width-2">
              </div>

              <!-- Email -->
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control form-control-border border-width-2">
              </div>

              <!-- Alamat -->
              <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="address" class="form-control form-control-border border-width-2">
              </div>

              <!-- Kecamatan -->
              <!-- Subdistrict -->
              <div class="form-group">
                <label>Kecamatan <code>*</code></label>
                <select class="form-control form-control-border border-width-2" name="subdistrict" required>
                  <option value="">Pilih Kecamatan</option>
                  @foreach($subdistricts as $subdistrict)
                    <option value="{{ $subdistrict->id }}">{{ $subdistrict->name }}</option>
                  @endforeach
                </select>
              </div>


             
          </div>
        </div>
      </div>

      <!-- right column -->
      <div class="col-md-6">
        <div class="card card-primary">
          <div class="card-header">
            <h6 class="card-title text-muted2">Detail Business</h6>
          </div>
          <div class="card-body">
            <!-- Tanggal Pendirian -->
            <div class="form-group">
              <label>Tanggal Pendirian</label>
              <input type="date" name="date_of_establishment" class="form-control form-control-border border-width-2">
            </div>

            <!-- Modal Awal -->
            <div class="form-group">
              <label>Modal Awal</label>
              <input type="text" name="initial_business_capital" class="form-control form-control-border border-width-2">
            </div>

            <!-- Pendapatan -->
            <div class="form-group">
              <label>Pendapatan</label>
              <input type="text" name="revenue" class="form-control form-control-border border-width-2">
            </div>

            <!-- Digitalisasi -->
            <div class="form-group">
              <label>Digitalisasi</label>
              <input type="text" name="digitalization" class="form-control form-control-border border-width-2">
            </div>

            <!-- Jumlah Karyawan -->
            <div class="form-group">
              <label>Jumlah Karyawan</label>
              <input type="text" name="employees_count" class="form-control form-control-border border-width-2">
            </div>

            <!-- Masalah Pengembangan -->
            <div class="form-group">
              <label>Masalah Pengembangan</label>
              <input type="text" name="development_problems" class="form-control form-control-border border-width-2">
            </div>

            <!-- Kebutuhan Pelatihan -->
            <div class="form-group">
              <label>Kebutuhan Pelatihan</label>
              <input type="text" name="training_needs" class="form-control form-control-border border-width-2">
            </div>

           <!-- Transaksi Penjualan -->
        <div class="form-group">
        <label>Transaksi Penjualan</label>
        <select name="is_sales_transaction" class="form-control form-control-border border-width-2">
            <option value="0">Tidak</option>
            <option value="1">Ya</option>
        </select>
        </div>

        <!-- Akses Pendanaan -->
        <div class="form-group">
        <label>Akses Pendanaan</label>
        <select name="is_access_to_funding" class="form-control form-control-border border-width-2">
            <option value="0">Tidak</option>
            <option value="1">Ya</option>
        </select>
        </div>

        <!-- Laporan Keuangan -->
        <div class="form-group">
        <label>Laporan Keuangan</label>
        <select name="is_financial_report" class="form-control form-control-border border-width-2">
            <option value="0">Tidak</option>
            <option value="1">Ya</option>
        </select>
        </div>

        <!-- Akun Bisnis -->
        <div class="form-group">
        <label>Akun Bisnis</label>
        <select name="is_business_account" class="form-control form-control-border border-width-2">
            <option value="0">Tidak</option>
            <option value="1">Ya</option>
        </select>
        </div>

         <!-- Tombol Simpan -->
         <button type="button" class="btn btn-primary btn-lg btn-block" id="btn-submit-add">Simpan</button>
            </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('addition_script')
<!-- FILE INPUT ** start -->
<!-- buffer.min.js and filetype.min.js are necessary in the order listed for advanced mime type parsing and more correct
     preview. This is a feature available since v5.5.0 and is needed if you want to ensure file mime type is parsed 
     correctly even if the local file's extension is named incorrectly. This will ensure more correct preview of the
     selected file (note: this will involve a small processing overhead in scanning of file contents locally). If you 
     do not load these scripts then the mime type parsing will largely be derived using the extension in the filename
     and some basic file content parsing signatures. -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/buffer.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/filetype.min.js" type="text/javascript"></script>
<!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
    wish to resize images before upload. This must be loaded before fileinput.min.js -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/piexif.min.js" type="text/javascript"></script>
<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
    This must be loaded before fileinput.min.js -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/sortable.min.js" type="text/javascript"></script>
<!-- the main fileinput plugin script JS file -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/fileinput.min.js"></script>
<!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`). Uncomment if needed. -->
<!-- script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/themes/fas/theme.min.js"></script -->
<!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/locales/LANG.js"></script>
<!-- FILE INPUT ** end   -->
<script src="{{ asset('assets/js/page.js').'?v='.date('YmdH').'2' }}"></script>
<script src="{{ asset('assets/js/admin/business_cu.js').'?v='.date('YmdH') }}"></script>
<!-- <script type="text/javascript">
  $(document).ready(function() {
  });
</script> -->
@endsection

@section('addition_css')
<!-- the fileinput plugin styling CSS file -->
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@endsection
