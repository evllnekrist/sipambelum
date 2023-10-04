
@extends('layouts.app')
@section('title', 'Berita')
@section('content')
<div class="content-wrapper">
  @include('includes.loading')
  <form method="post" action="#" id="form">
    <div class="container-fluid">
      <input type="text" name="check_validity" value="1" class="form-control form-control-sm form-control form-control-sm-border border-width-2" hidden>
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="text-muted2">Tambah Baru</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" target="_blank">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.news')}}" target="_blank">Berita</a></li>
            <li class="breadcrumb-item active">Tambah</li>
          </ol>
        </div>
      </div>

      <div class="row">
        <div class="col-md-8">
          <div class="card card-primary">
            <div class="card-header">
              <h6 class="card-title text-muted2">Konten</h6>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label>Judul <code>*</code></label>
                <input name="title" class="form-control form-control-sm" required>
              </div>
              <div class="form-group">
                <label>Slug <code>*</code></label>
                <input name="slug" class="form-control form-control-sm nospace lowercase" required>
              </div>
              <div class="form-group">
                <label>Upload: Gambar <code>*</code></label><br>
                <input id="input-file" name="img_main" type="file" class="file" data-browse-on-zone-click="true">
              </div>
              <div class="form-group">
                <label>Isi Berita</label>
                <textarea id="summernote" name="content"></textarea>
              </div>
            </div>
          </div>
          <!-- CONTENT :: END -->
        </div>
        <!-- KONTEN :: END -->
        <!-- KONTEN2 :: START -->
        <div class="col-md-4">
          <div class="card card-success">
            <div class="card-header">
              <h6 class="card-title text-muted2">Meta</h6>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label>Status <code>*</code></label>
                <select name="status" class="form-control select2bs4" style="width: 100%;" required>
                  <option value="new">Baru</option>
                  <option value="draft">Draft</option>
                </select>
              </div>
              <div class="form-group">
                <label>Penulis</label>
                <input type="text" name="author" class="form-control" required>
              </div>
              <hr>
              <div class="form-group">
                <label class="text-info">Tag</label><footer class="label_subtitle label_squeeze">Daftarkan kata kunci untuk berita ini, untuk membantu pencarian</footer>
                <div class="select2-purple">
                  <select name="keywords[]" class="select2tag" multiple="multiple" data-dropdown-css-class="select2-purple" style="width: 100%;">
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- KONTEN2 :: END -->
      </div>
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
<script src="{{ asset('assets/js/admin/news_cu.js').'?v='.date('YmdH') }}?ver=23051701"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    $('.select2tag').select2({
      tags: true,
      tokenSeparators: [',']
    })
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