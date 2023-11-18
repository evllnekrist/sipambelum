@extends('layouts.app')
@section('title', 'Konfigurasi')
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
            <li class="breadcrumb-item"><a href="{{route('admin.config')}}" target="_blank">Konfigurasi</a></li>
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
                <label>Kode <code>*</code></label> <footer class="label_subtitle label_squeeze">Menjadi kode unik untuk konfigurasi ini</footer>
                <input type="text" name="code" class="form-control form-control-border border-width-2 nospace lowercase slug" required>
              </div>
              <div class="form-group">
                <label>Label <code>*</code></label>
                <input name="label" class="form-control form-control-sm" required>
              </div>
              <div class="form-group">
                <label>Upload: Gambar <code>*</code></label><br>
                <input id="input-file" name="img_main" type="file" class="file" data-browse-on-zone-click="true">
              </div>
              <div class="form-group">
                <label>Nilai</label>
                <textarea id="summernote" name="value"></textarea>
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
                <label>Link URL <code>*</code></label>
                <input type="text" name="url_link" class="form-control" required>
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
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/buffer.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/filetype.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/piexif.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/sortable.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/fileinput.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/locales/LANG.js"></script>
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js').'?v='.date('YmdH') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js').'?v='.date('YmdH') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js').'?v='.date('YmdH') }}"></script>
<!-- DATE INPUT ** end   -->
<script src="{{ asset('assets/js/page.js').'?v='.date('YmdH').'2' }}"></script>
<script src="{{ asset('assets/js/admin/config_cu.js').'?v='.date('YmdH') }}?ver=23051701"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.select2bs4').select2({
      theme: 'bootstrap4'
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
