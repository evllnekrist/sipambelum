
@extends('layouts.app')
@section('title', 'Potensi Lokal')
@section('content')
<div class="content-wrapper">
  @include('includes.loading')
  <form method="post" action="#" id="form" enctype="multipart/form-data">
    @csrf
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="text-muted2">Tambah Baru</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" target="_blank">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.local-potential')}}" target="_blank">Potensi Lokal</a></li>
            <li class="breadcrumb-item active">Tambah</li>
          </ol>
        </div>
      </div>
      <div class="row">
        <!-- left column -->
        <div class="col-md-8">
          <div class="card card-primary">
            <div class="card-header">
              <h6 class="card-title text-muted2">Potensi Lokal</h6>
            </div>
    <div class="container-fluid">
        <!-- Konten Form -->
        <!-- Nama -->
        <div class="form-group">
          <label>Nama <code>*</code></label>
          <input type="text" name="name" class="form-control form-control-border border-width-2" required>
        </div>

        <!-- Deskripsi -->
        <div class="form-group">
          <label>Deskripsi <code>*</code></label>
          <input type="text" name="desc" class="form-control form-control-border border-width-2" required>
        </div>

        <!-- Gambar Utama -->
        <div class="form-group">
          <label>Gambar Utama <code>*</code></label>
          <input type="file" name="img_main" id="input-file" class="form-control form-control-border border-width-2" required>
        </div>

        <!-- URL Link -->
        <div class="form-group">
          <label>URL Link <code>*</code></label>
          <input type="text" name="url_link" class="form-control form-control-border border-width-2" required>
        </div>

        <!-- Aktif -->
        <div class="form-group">
          <label>Aktif <code>*</code></label>
          <select class="form-control form-control-border border-width-2" name="active" required>
            <option value="1">Aktif</option>
            <option value="0">Tidak Aktif</option>
          </select>
        </div>
        <!-- <div class="form-group">
        <label>Kecamatan <code>*</code></label>
        <footer class="label_subtitle label_squeeze">Jika lebih dari 1, Pencet keyboard CTRL + KLIK</footer>
        <select class="form-control form-control-border border-width-2 selectpicker" name="subdistrict[]" multiple data-live-search="true" required>
            <option value="">Pilih Kecamatan</option>
            @foreach($subdistricts as $subdistrict)
                <option value="{{ $subdistrict->id }}">{{ $subdistrict->name }}</option>
            @endforeach
        </select>
    </div> -->
    <div class="form-group">
    <label>Kecamatan <code>*</code></label>
    <footer class="label_subtitle label_squeeze">Daftar akan menyesuaikan potensi lokal yang dipilih</footer>
    <select class="select2bs4" name="subdistricts[]" multiple="multiple" required>
        @foreach ($subdistricts as $item)
            <option value="{{$item->id}}">{{$item->name}}</option>
        @endforeach
    </select>
</div>

        <!-- Tombol Simpan -->
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-submit-add">Simpan</button>
        </div>
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
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js').'?v='.date('YmdH') }}"></script>
<!-- FILE INPUT ** end   -->
<script src="{{ asset('assets/js/page.js').'?v='.date('YmdH').'2' }}"></script>
<script src="{{ asset('assets/js/admin/local_potential_cu.js').'?v='.date('YmdH') }}"></script>
<script type="text/javascript">

  $(document).ready(function() {
    $('.select2bs4').select2({    
      placeholder: "Pilih salah satu....",
    })
    $('#summernote').summernote({
      placeholder: 'Tulis sesuatu disini....',
      tabsize: 2,
      height: 200
    })
    $('[name="subdistricts"]').change(function(){
      if(($(this).val()).includes('all') && $(this).val().length > 1){
        $('[name="subdistricts"]').val(['all']).trigger('change')
      }
    })
  });
</script>
@endsection

@section('addition_css')
<!-- the fileinput plugin styling CSS file -->
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
@endsection