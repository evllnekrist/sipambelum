
@extends('layouts.app')
@section('title', 'Trainee')
@section('content')
<div class="content-wrapper">
  @include('includes.loading')
  <form method="post" action="#" id="form">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="text-muted2">Tambah Baru</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" target="_blank">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.trainee')}}" target="_blank">Peserta</a></li>
            <li class="breadcrumb-item active">Tambah</li>
          </ol>
        </div>
      </div>
      <div class="row">
        <!-- left column -->
        <div class="col-md-8">
          <div class="card card-primary">
            <div class="card-header">
              <h6 class="card-title text-muted2">Peserta</h6>
            </div>
   
    <div class="container-fluid">
      <!-- NIK -->
      <div class="form-group">
        <label>Nik <code>*</code></label>
        <input type="text" name="nik" class="form-control form-control-border border-width-2" required>
      </div>
      
      <!-- Nama -->
      <div class="form-group">
        <label>Nama <code>*</code></label>
        <input type="text" name="name" class="form-control form-control-border border-width-2" required>
      </div>

      <!-- Level -->
      <!-- <div class="form-group">
        <label>Level</label>
        <select class="form-control form-control-border border-width-2" name="level">
          <option value="new">New</option>
          <option value="beginner">Beginner</option>
          <option value="mid">Mid</option>
          <option value="Expert">Expert</option>
        </select>
      </div> -->

      <!-- Jenis Kelamin -->
      <div class="form-group">
        <label>Jenis Kelamin</label>
        <select class="form-control form-control-border border-width-2" name="sex">
          <option value="m">Laki-Laki</option>
          <option value="f">Perempuan</option>
        </select>
      </div>

      <!-- Agama -->
      <div class="form-group">
    <label>Agama</label>
    <select class="form-control form-control-border border-width-2" name="religion">
        <option value="">Pilih Agama</option>
        <option value="Islam">Islam</option>
        <option value="Kristen">Kristen</option>
        <option value="Katolik">Katolik</option>
        <option value="Hindu">Hindu</option>
        <option value="Buddha">Buddha</option>
        <option value="Konghucu">Konghucu</option>
    </select>
</div>


      <!-- Tempat Lahir -->
      <div class="form-group">
        <label>Tempat Lahir</label>
        <input type="text" name="place_of_birth" class="form-control form-control-border border-width-2">
      </div>

      <!-- Tanggal Lahir -->
      <div class="form-group">
        <label>Tanggal Lahir</label>
        <input type="date" name="date_of_birth" class="form-control form-control-border border-width-2">
      </div>

      <!-- Pendidikan Terakhir -->
      <div class="form-group">
        <label>Pendidikan Terakhir</label>
        <input type="text" name="latest_edu" class="form-control form-control-border border-width-2">
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

      <!-- Kecamatan Tempat Tinggal -->
      <div class="form-group">
    <label>Kecamatan Tempat Tinggal<code>*</code></label>
    @if(in_array(Auth::user()->role, ['70x7', 'opd']))
        <select class="form-control form-control-border border-width-2" name="subdistrict_of_residence" required>
            <option value="">Pilih Kecamatan</option>
            @foreach($subdistricts as $subdistrict)
                <option value="{{ $subdistrict->id }}">{{ $subdistrict->name }}</option>
            @endforeach
        </select>
    @endif

    @if(in_array(Auth::user()->role, ['kec']))
        <input type="hidden" name="subdistrict_of_residence" class="form-control form-control-border border-width-2" value="{{ Auth::user()->subdistrict }}" readonly>
    @endif
</div>

      <!-- Tombol Simpan -->
      <button type="button" class="btn btn-primary btn-lg btn-block" id="btn-submit-add">Simpan</button>
    </div>
  </form>
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
<script src="{{ asset('assets/js/admin/trainee_cu.js').'?v='.date('YmdH') }}"></script>
<!-- <script type="text/javascript">
  $(document).ready(function() {
  });
</script> -->
@endsection

@section('addition_css')
<!-- the fileinput plugin styling CSS file -->
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@endsection
