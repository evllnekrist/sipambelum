
@extends('layouts.app')
@section('title', 'Halaman Web')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  @include('includes.loading')
  <form method="post" action="#" id="form">
    <div class="container-fluid">
      <input type="text" name="check_validity" value="1" class="form-control form-control-border border-width-2" hidden>
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="text-muted2">Tambah Baru</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" target="_blank">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.page')}}" target="_blank">Halaman Web</a></li>
            <li class="breadcrumb-item active">Tambah</li>
          </ol>
        </div>
      </div>
    
      <div class="row">
        <!-- left column -->
        <div class="col-md-8">
          <div class="card card-primary">
            <div class="card-header">
              <h6 class="card-title text-muted2">Konten</h6>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <!-- <div class="form-group">
                <label>Kode <code>*</code></label> <footer class="label_subtitle label_squeeze">Untuk diaplikasikan ke web, beritahukan kode ini ke developer. Bersifat unik, tidak boleh sama</footer>
                <input type="text" name="code" class="form-control form-control-border border-width-2 nospace lowercase" required>
              </div> -->
              <div class="form-group">
                <label>Slug <code>*</code></label> <footer class="label_subtitle label_squeeze">Menjadi alamat untuk laman ini (contoh <i>/<b>visi-misi</b></i>). Bersifat unik, tidak boleh sama</footer>
                <input type="text" name="slug" class="form-control form-control-border border-width-2 nospace lowercase slug" required>
                <div id="slug-info"></div>
              </div>
              <div class="form-group">
                <label>Gambar Utama <code>*</code></label>
                <input id="input-file" name="img_main" type="file" class="file" data-browse-on-zone-click="true">
              </div>
              <div class="form-group">
                <label>Judul <code>*</code></label>
                <input type="text" name="title" class="form-control form-control-border border-width-2" required>
              </div>
              <div class="form-group">
                <label>Konten <code>*</code></label>
                <textarea id="summernote" name="body"></textarea>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-4"></div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div>
    <button type="button" class="btn btn-primary btn-lg btn-block" id="btn-submit-add">Simpan</button>
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
<!-- DATE INPUT ** start -->
<!-- date-range-picker -->
<script src="{{ asset('assets/plugins/moment/moment.min.js').'?v='.date('YmdH') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js').'?v='.date('YmdH') }}"></script>
<!-- DATE INPUT ** end   -->
<script src="{{ asset('assets/js/page.js').'?v='.date('YmdH').'2' }}"></script>
<script src="{{ asset('assets/js/admin/page_cu.js').'?v='.date('YmdH') }}?ver=23051701"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#summernote').summernote({
      placeholder: 'Tulis sesuatu disini....',
      tabsize: 2,
      height: 200
    })
  });
</script>
@endsection

@section('addition_css')
<!-- the fileinput plugin styling CSS file -->
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
@endsection