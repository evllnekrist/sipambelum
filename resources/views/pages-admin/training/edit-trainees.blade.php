
@extends('layouts.app')
@section('title', 'Pelatihan')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  @include('includes.loading')
  <form method="post" action="#" id="form">
    <!-- <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="text-muted2">Kelola Peserta</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" target="_blank">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.training')}}" target="_blank">Pelatihan</a></li>
            <li class="breadcrumb-item active">Kelola Peserta</li>
          </ol>
        </div>
      </div>
    </div> -->
    <div class="container-fluid">
      <input type="text" name="id" value="{{@$selected->id}}" class="form-control form-control-border border-width-2" hidden>
      
      
			<div class="image-cover hero_banner hero_banner-top" style="background:url(https://via.placeholder.com/2200x1100) no-repeat;" data-overlay="5">
				<div class="container">
					
					<h3 class="notsobig-header-capt mb-0">Cari Peserta</h3>
					<p class="text-center text-smaller mb-4">Find new & featured property located in your local city.</p>
					<div class="row justify-content-center">
						<div class="col-xl-10 col-lg-12 col-md-12">
							<div class="full_search_box nexio_search lightanic_search hero_search-radius modern">
								<div class="search_hero_wrapping">
							
									<div class="row">
										<div class="col-md-4 col-sm-12">
											<div class="form-group">
												<label class="text-smaller">Kecamatan</label>
												<div class="input-with-icon">
													<select id="location" class="form-control">
														<option value="">&nbsp;</option>
                                                        @foreach($subdistricts as $item)
														<option value="{{$item->id}}">{{$item->name}}</option>
                                                        @endforeach
													</select>
												</div>
											</div>
										</div>
										
										<div class="col-md-3 col-sm-12">
											<div class="form-group">
												<label class="text-smaller">Level Peserta</label>
												<div class="input-with-icon">
													<select id="ptypes" class="form-control">
														<option value="">&nbsp;</option>
                                                        @foreach($grade_levels as $item)
														<option value="{{$item->value}}">{{$item->label}}</option>
                                                        @endforeach
													</select>
												</div>
											</div>
										</div>
										
										<div class="col-md-4 col-sm-12 d-md-none d-lg-block">
											<div class="form-group">
												<label class="text-smaller">Nama/NIK</label>
                                                <input type="text" class="form-control search_input border-0" placeholder="ex. Nama Anda" />
											</div>
										</div>
										
										<div class="col-md-1 col-sm-12 small-padd">
											<div class="form-group none">
												<button type="button" class="btn theme-bg full-width" id="btn-trainees-search"><i class="fa fa-search"></i></button>
											</div>
										</div>
									</div>
                                    <!-- Collapse: Search -->
                                    <div id="advance-search" aria-expanded="false" style="display:none">
                                        <!-- row -->
                                        <div class="row">
                                        
                                            <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                                                <h6 class="text-dark">Pilih dari hasil pencarian berikut :</h6>
                                                <ul class="no-ul-list third-row">
                                                    <li>
                                                        <input id="a-1" class="form-check-input" name="a-1" type="checkbox">
                                                        <label for="a-1" class="form-check-label">Air Condition</label>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                        </div>
                                        <!-- /row -->
                                        <!-- row -->
                                        <div class="row">
                                            <button type="button" class="btn theme-bg btn-md btn-block" id="btn-trainees-add">Tambahkan</button>
                                        </div>
                                        <!-- /row -->
                                    </div>
									
								</div>
							</div>
							
						</div>
					</div>
                    
				</div>
			</div>

    </div>
    <button type="button" class="btn btn-primary btn-lg btn-block mt-5" id="btn-submit-edit">Simpan</button>
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
<!-- DATE INPUT ** end   -->
<script src="{{ asset('assets/js/page.js').'?v='.date('YmdH').'2' }}"></script>
<script src="{{ asset('assets/js/admin/training_cu.js').'?v='.date('YmdH') }}"></script>
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