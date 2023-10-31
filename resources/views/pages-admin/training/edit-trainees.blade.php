
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
        <?php
            // echo "<pre>";
            // dump($trainees);
            // echo "</pre>";
        ?>
      
        <div class="image-cover hero_banner hero_banner-top hero_banner-minheight" style="background:url(https://via.placeholder.com/2200x550) no-repeat;" data-overlay="5">
            <div class="container">
                
                <h3 class="notsobig-header-capt mb-0">Cari Peserta</h3>
                <p class="text-center text-smaller mb-4">Tambahkan peserta untuk pelatihan: <b class="text-blue-b">{{$selected->name}}</b></p>
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-12 col-md-12">
                        <div class="full_search_box nexio_search lightanic_search hero_search-radius modern">
                            <div class="search_hero_wrapping">
                        
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class="text-smaller">Kecamatan</label>
                                            <div class="input-with-icon">
                                                <select id="subdistrict" class="form-control">
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
                                                <select id="level" class="form-control">
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
                                            <input type="text" id="search" class="form-control search_input border-0" placeholder="ex. Nama Anda" />
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
                                            <ul class="no-ul-list third-row" id="advance-search-trainee-list"></ul>
                                        </div>
                                        
                                    </div>
                                    <!-- /row -->
                                    <!-- row -->
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="button" class="btn theme-bg btn-md btn-block" id="btn-trainees-add">Tambahkan</button>
                                        </div>
                                        <div class="col-6">
                                            <button type="button" class="btn btn-warning btn-md btn-block" id="btn-trainees-add-cancel">Batal</button>
                                        </div>
                                    </div>
                                    <!-- /row -->
                                </div>
                                <div id="advance-search-info" aria-expanded="false" style="display:none" class="my-5">
                                    <div id="advance-search-info-content"></div>
                                    <div id="advance-search-loading">
                                        <center><img src="{{asset('assets/img/loading.gif')}}"></center>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row text-smaller mb-5">
                            <div class="col-6">
                                <table>
                                    <tr>
                                        <td>Total tampil</td>
                                        <td>:</td>
                                        <td id="summary-count-trainees-displayed"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><hr></td>
                                    </tr>
                                    <tr>
                                        <td>Disetujui</td>
                                        <td>:</td>
                                        <td id="summary-count-trainees-approved"></td>
                                    </tr>
                                    <tr>
                                        <td>Belum Disetujui</td>
                                        <td>:</td>
                                        <td id="summary-count-trainees-approved-not"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><hr></td>
                                    </tr>
                                    <tr>
                                        <td>Lulus</td>
                                        <td>:</td>
                                        <td id="summary-count-trainees-passed"></td>
                                    </tr>
                                    <tr>
                                        <td>Tidak Lulus</td>
                                        <td>:</td>
                                        <td id="summary-count-trainees-passed-not"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-6" style="text-align:end">
                                <div class="_leads_action">
                                    Aksi Massal: 
                                    <a class="bg-danger text-white trainee-delete" title="hapus"><i class="ti-close"></i></a>
                                    <a class="theme-bg text-white trainee-approve" title="setujui"><i class="ti-check"></i></a>
                                    <a class="text-white trainee-approve-not" style="background-color:grey" title="batal setujui"><i class="ti-layout-width-full"></i></a>
                                </div>
                            </div>
                        </div>
                        @php
                            $subdistrict_ids        = [];
                            $trainees_approved      = [];
                            $trainees_passed        = [];
                            $trainees_passed_not    = [];
                        @endphp
                        <!-- subdistrict::start -->
                        <ol>
                        @foreach($subdistricts as $item)
                        @php
                            $trainees_subdistrict = [];
                            array_push($subdistrict_ids,$item->id);
                            if($trainees){
                                foreach($trainees as $key_trainee => $item_trainee){
                                    if(@$item_trainee->trainee->subdistrict_of_residence == $item->id){
                                        array_push($trainees_subdistrict, $item_trainee);
                                        unset($trainees[$key_trainee]);
                                    }
                                }
                            }
                        @endphp
                        <li>
                            <h6 class="text-muted">{{$item->name}}</h6>
                            <div class="table-responsive subdistrict-table" id="subdistrict-{{$item->id}}-wrap" style="{{$trainees_subdistrict?'':'display:none'}}">
                                <table class="table table-sm text-smaller">
                                    <thead class="table-muted2">
                                        <tr>
                                            <th scope="col"><input type="checkbox" class="check-all" data-group="{{$item->id}}"></th>
                                            <th scope="col">Nama/NIK</th>
                                            <th scope="col">Level</th>
                                            <th scope="col">Terkait UMKM</th>
                                            <th scope="col">Kelas Terdahulu</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="subdistrict-{{$item->id}}-tbody">
                                        @foreach($trainees_subdistrict as $key_ts => $item_ts)
                                        <?php
                                            // echo "<pre>";
                                            // dump($item_ts);
                                            // echo "</pre>";
                                            if($item_ts->active){
                                                array_push($trainees_approved,$item_ts->trainee->id);
                                            }
                                            if($item_ts->is_passed){
                                                array_push($trainees_passed,$item_ts->trainee->id);
                                            }elseif($item_ts->is_passed===0){
                                                array_push($trainees_passed_not,$item_ts->trainee->id);
                                            }
                                        ?>
                                        <tr class="trainee-wrap" id="subdistrict-{{$item_ts->trainee->id}}-trainee">
                                            <td>
                                                <input type="checkbox" class="check-all-group-{{$item->id}} checkbox-trainee" data-id="{{$item_ts->trainee->id}}">
                                            </td>
                                            <td class="row">
                                                <div class="col-3" id="trainee-{{$item_ts->trainee->id}}-approved-wrap">
                                                    @if($item_ts->active)
                                                        <i class="fas fa-check fa-lg text-blue-b trainee-approved" id="trainee-{{$item_ts->trainee->id}}-approved"></i>
                                                    @endif
                                                </div>
                                                <div class="col-9">
                                                    <b>{{$item_ts->trainee->name}}</b><br>
                                                    <span>{{$item_ts->trainee->nik}}</span><br>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="_leads_status"><span class="active">{{$item_ts->trainee->level}}</span></div>
                                                <span>Update terakhir {{ date($item_ts->trainee->created_at) }}</span>
                                            </td>
                                            <td>
                                            <a onclick="displayBusiness({{$item_ts->trainee->id}})" class="text-blue-b">lihat</a>
                                            </td>
                                            <td>
                                            <a onclick="displayClass({{$item_ts->trainee->id}})" href="" class="text-blue-b">lihat</a>
                                            </td>
                                            <td>
                                                <div class="_leads_action" data-id="{{$item_ts->trainee->id}}">
                                                    <button type="button" class="btn {{$item_ts->is_passed===0?'bg-danger':'bg-muted text-muted2'}} btn-lg trainee-passed-not" style="margin-top:-5px">Tidak</button>
                                                    <button type="button" class="btn {{$item_ts->is_passed?'bg-success':'bg-muted text-muted2'}} btn-lg trainee-passed" style="margin-top:-5px">Lulus</button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </li>
                        @endforeach
                        </ol>
                        <!-- subdistrict::end -->
                        <input type="text" name="subdistrict_ids" value="{{implode(',',@$subdistrict_ids)}}" class="form-control form-control-border border-width-2" hidden>
                        <input type="text" name="trainees_approved" value="{{implode(',',@$trainees_approved)}}" class="form-control form-control-border border-width-2" hidden>
                        <input type="text" name="trainees_passed" value="{{implode(',',@$trainees_passed)}}" class="form-control form-control-border border-width-2" hidden>
                        <input type="text" name="trainees_passed_not" value="{{implode(',',@$trainees_passed_not)}}" class="form-control form-control-border border-width-2" hidden>
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
<script src="{{ asset('assets/js/admin/training_trainee_cu.js') }}"></script>
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