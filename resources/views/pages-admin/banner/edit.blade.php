
@extends('layouts.app')
@section('title', 'Banner')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  @include('includes.loading')
  <form method="post" action="#" id="form">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="text-muted2">Ubah</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" target="_blank">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.banner')}}" target="_blank">Banner</a></li>
            <li class="breadcrumb-item active">Ubah</li>
          </ol>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <input type="text" name="id" value="{{@$selected->id}}" class="form-control form-control-border border-width-2" hidden>
      <div class="row">
        <!-- left column -->
        <div class="col-md-8">
          <div class="card card-primary">
            <div class="card-header">
              <h6 class="card-title text-muted2">Konten</h6>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="form-group">
                <label>Nama Banner <code>*</code></label>
                <input type="text" name="name" value="{{@$selected->name}}"
                class="form-control form-control-border border-width-2" required>
              </div>
              <div class="form-group">
                <label>Gambar Banner <code>*</code></label>
                @if($selected->img_main)
                  <br><img src="{{asset($selected->img_main)}}" id="input-file-prev" style="max-width:30vw;max-height:40vh">
                  <br><u><a onclick="display('input-file-wrap','input-file-prev')" id="input-file-wrap-action-text" class="text-primary">Ganti Gambar</a></u>
                @endif
                <div id="input-file-wrap" data-display="hide" {{$selected->img_main?'style=display:none':''}}>
                  <input id="input-file" name="img_main" type="file" class="file" data-browse-on-zone-click="true">
                </div>
              </div>
              <div class="form-group">
                <label>Redirect Link</label> <footer class="label_subtitle label_squeeze">jika diisi, menjadi arah ketika banner di klik</footer>
                <input type="text" name="url_link" value="{{@$selected->url_link}}"
                class="form-control form-control-border border-width-2">
              </div>
              <div class="form-group">
                <label>Judul</label> <footer class="label_subtitle label_squeeze">jika diisi, akan tampil sebagai tulisan besar di dalam banner</footer>
                <input type="text" name="title" value="{{@$selected->title}}"
                class="form-control form-control-border border-width-2">
              </div>
              <div class="form-group">
                <label>Sub-Judul</label> <footer class="label_subtitle label_squeeze">jika diisi, akan tampil sebagai tulisan kecil di dalam banner</footer>
                <input type="text" name="subtitle" value="{{@$selected->subtitle}}"
                class="form-control form-control-border border-width-2">
              </div>
              <div class="form-group">
                <label>Tombol Text</label> <footer class="label_subtitle label_squeeze">jika diisi, tombol akan muncul dengan text ini</footer>
                <input type="text" name="button_title" value="{{@$selected->button_title}}"
                class="form-control form-control-border border-width-2">
              </div>
              <div class="form-group">
                <label>Tombol Link</label> <footer class="label_subtitle label_squeeze">jika diisi, menjadi arah ketika tombol di klik</footer>
                <input type="text" name="button_link" value="{{@$selected->button_link}}"
                class="form-control form-control-border border-width-2">
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
                    <option value="{{$i}}" {{$i==@$selected->sequence?'selected':''}}>Ke-{{$i}}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group">
                <label>Terbitkan Dari <code>*</code></label>
                <input type="datetime-local" name="publish_start" class="form-control" 
                  value="{{$selected->publish_start?date('Y-m-d\TH:i:s', strtotime($selected->publish_start)):''}}">
              </div>
              <div class="form-group">
                <label>Terbitkan Hingga</label> <footer class="label_subtitle label_squeeze">kosongkan, jika banner tidak memiliki <i>expired</i></footer>
                <div class="input-group date" id="publishdatetime2" data-target-input="nearest">
                  <input type="text" name="publish_end" value="{{$selected->publish_end?date('m/d/Y H::i::s', strtotime($selected->publish_end)):''}}"
                  class="form-control datetimepicker-input" data-target="#publishdatetime2"/>
                  <div class="input-group-append" data-target="#publishdatetime2" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div>
    <button type="button" class="btn btn-primary btn-lg btn-block" id="btn-submit-edit">Simpan</button>
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
<!-- DATE INPUT ** start -->
<!-- date-range-picker -->
<script src="{{ asset('assets/plugins/moment/moment.min.js').'?v='.date('YmdH') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js').'?v='.date('YmdH') }}"></script>
<!-- DATE INPUT ** end   -->
<script src="{{ asset('assets/js/page.js').'?v='.date('YmdH').'2' }}"></script>
<script src="{{ asset('assets/js/admin/banner_cu.js').'?v='.date('YmdH') }}?ver=23051701"></script>
@endsection

@section('addition_css')
<!-- the fileinput plugin styling CSS file -->
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@endsection