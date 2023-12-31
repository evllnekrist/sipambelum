
@extends('layouts.app')
@section('title', 'Pelatihan')
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
            <li class="breadcrumb-item"><a href="{{route('admin.training')}}" target="_blank">Pelatihan</a></li>
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
                <label>Nama Pelatihan <code>*</code></label>
                <input type="text" name="name" class="form-control form-control-border border-width-2" required>
              </div>
              <div class="form-group">
                <label>Penyelenggara <code>*</code></label>
                <select class="select2bs4" name="organizer" required>
                  <option></option>
                  @foreach ($organizers as $item)
                      <option value="{{$item->value}}">{{$item->label}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Potensi Lokal Terkait <code>*</code></label>
                <select class="select2bs4" name="id_local_potential" required>
                  <option></option>
                  @foreach ($potentials as $item)
                      <option value="{{$item->id}}">{{$item->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Kecamatan <code>*</code></label>
                <footer class="label_subtitle label_squeeze">Daftar akan menyesuaikan potensi lokal yang dipilih</footer>
                <select class="select2bs4" name="subdistricts[]" multiple="multiple" required>
                  <option value="all">Semua (yang sesuai dengan potensi lokal)</option>
                  @foreach ($subdistricts as $item)
                      <option value="{{$item->id}}">{{$item->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Upload: Gambar <code>*</code></label>
                <input id="input-file" name="img_main" type="file" class="file" data-browse-on-zone-click="true">
              </div>
              <div class="form-group">
                <label>Deskripsi </label>
                <textarea id="summernote" name="desc"></textarea>
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
                <label>Level Pelatihan <code>*</code></label>
                <select class="select2bs4" name="level" required>
                  @foreach ($levels as $item)
                      <option value="{{$item->value}}">{{$item->label}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Limit Peserta <code>*</code></label> <footer class="label_subtitle label_squeeze">Biarkan 0 untuk jumlah peserta tak terbatas</footer>
                <input type="number" name="trainee_limit" class="form-control form-control-border border-width-2" required>
              </div>
              <div class="form-group">
                <label>Acara Berlangsung Dari <code>*</code></label>
                <input type="datetime-local" name="event_start" class="form-control" required/>
              </div>
              <div class="form-group">
                <label>Acara Berlangsung Hingga</label> <code>*</code></footer>
                <input type="datetime-local" name="event_end" class="form-control" required/>
              </div>
              <hr style="margin: 30px 0px 30px 0px !important">
              <div class="form-group">
                <label>Metode <code>*</code></label>
                <ul class="no-ul-list no-ul-list-inline">
                  <li>
                    <input id="io" class="form-check-input" name="is_online" value="0" type="radio" required>
                    <label for="io" class="form-check-label">Offline&nbsp;&nbsp;</label>
                  </li>
                  <li>
                    <input id="io2" class="form-check-input" name="is_online" value="1" type="radio">
                    <label for="io2" class="form-check-label">Online</label>
                  </li>
                </ul>
              </div>
              <div class="form-group">
                <label>Alamat <code>*</code></label>
                <textarea name="address" class="form-control h-120" required></textarea>
              </div>
              <div class="form-group">
                <label>Kontak Telepon</label> <footer class="label_subtitle label_squeeze">Jika lebih dari 1, pisahkan dengan comma (,)</footer>
                <input type="text" name="contact_phone" placeholder="08** **** ****" class="form-control form-control-border border-width-2 no-space">
              </div>
              <div class="form-group">
                <label>Kontak Email</label> <footer class="label_subtitle label_squeeze">Jika lebih dari 1, pisahkan dengan comma (,)</footer>
                <input type="email" name="contact_email" placeholder="____@____.com" class="form-control form-control-border border-width-2">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <!--/.col (right) -->
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
<script src="{{ asset('assets/js/page.js').'?v='.date('YmdH').'2' }}"></script>
<script src="{{ asset('assets/js/admin/training_cu.js').'?v='.date('YmdH') }}"></script>
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