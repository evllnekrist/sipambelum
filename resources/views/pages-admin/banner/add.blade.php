
@extends('layouts.app')
@section('title', 'Banner')
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
            <li class="breadcrumb-item"><a href="{{route('admin.banner')}}" target="_blank">Banner</a></li>
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

            <div class="card-body">
              <div class="form-group">
                <label>Nama Banner <code>*</code></label>
                <input type="text" name="name" class="form-control form-control-border border-width-2" required>
              </div>
              <div class="form-group">
                <label>Gambar Banner <code>*</code></label>
                <input id="input-file" name="img_main" type="file" class="file" data-browse-on-zone-click="true">
              </div>
              <div class="form-group">
                <label>Redirect Link</label> <footer class="label_subtitle label_squeeze">jika diisi, menjadi arah ketika banner di klik</footer>
                <input type="text" name="url_link" class="form-control form-control-border border-width-2">
              </div>
              <div class="form-group">
                <label>Judul</label> <footer class="label_subtitle label_squeeze">jika diisi, akan tampil sebagai tulisan besar di dalam banner</footer>
                <input type="text" name="title" class="form-control form-control-border border-width-2">
              </div>
              <div class="form-group">
                <label>Sub-Judul</label> <footer class="label_subtitle label_squeeze">jika diisi, akan tampil sebagai tulisan kecil di dalam banner</footer>
                <input type="text" name="subtitle" class="form-control form-control-border border-width-2">
              </div>
              <div class="form-group">
                <label>Tombol Text</label> <footer class="label_subtitle label_squeeze">jika diisi, tombol akan muncul dengan text ini</footer>
                <input type="text" name="button_title" class="form-control form-control-border border-width-2">
              </div>
              <div class="form-group">
                <label>Tombol Link</label> <footer class="label_subtitle label_squeeze">jika diisi, menjadi arah ketika tombol di klik</footer>
                <input type="text" name="button_link" class="form-control form-control-border border-width-2">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-4">
          <div class="card card-secondary">
            <div class="card-header">
              <h6 class="card-title text-muted2">Pengaturan</h6>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="form-group">
                <label>Urutan <code>*</code></label>
                <select class="custom-select" name="sequence">
                  <option value="">Pilih salah satu:</option>
                  @for($i = 1; $i <= 50; $i++)
                    <option value="{{$i}}" {{$i==50?'selected':''}}>Ke-{{$i}}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group">
                <label>Terbitkan Dari <code>*</code></label>
                <input type="datetime-local" name="publish_start" class="form-control" required/>
              </div>
              <div class="form-group">
                <label>Terbitkan Hingga</label> <footer class="label_subtitle label_squeeze">kosongkan, jika banner tidak memiliki <i>expired</i></footer>
                <input type="datetime-local" name="publish_end" class="form-control"/>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
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
<!-- FILE INPUT ** end   -->
<script src="{{ asset('assets/js/page.js').'?v='.date('YmdH').'2' }}"></script>
<script src="{{ asset('assets/js/admin/banner_cu.js').'?v='.date('YmdH') }}"></script>
<!-- <script type="text/javascript">
  $(document).ready(function() {
  });
</script> -->
@endsection

@section('addition_css')
<!-- the fileinput plugin styling CSS file -->
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@endsection