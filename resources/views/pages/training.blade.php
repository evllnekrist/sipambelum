@extends('layouts.app-public')
@section('title', 'Pelatihan')
@section('content')
    <div id="main-wrapper">	
			<!-- ============================ All Property ================================== -->
			<section class="gray pt-4">	
        <div class="container">
          <?php
            // echo "<pre>";
            // print_r($_GET);
            // echo "</pre>";
            $get_level = @$_GET['level']?exgetTrainingode(',',strtoupper($_GET['level'])):array();
          ?>
          <div class="row m-0">
            <div class="short_wraping">
              <div class="row align-items-center">

                <div class="col-lg-6 col-md-7 col-sm-12 order-lg-2 order-md-3 elco_bor col-sm-12">
                  <div class="shorting_pagination">
                    <div class="shorting_pagination_laft">
                      <h5>
                        Menampilkan <span id="products_count_start"></span> - <span id="products_count_end"></span>
                        dari <span id="products_count_total"></span> data
                      </h5>
                      <input name="_page" value="1" hidden>
                    </div>
                    <div class="shorting_pagination_right">
                      <ul id="_pagination">
                      </ul>
                    </div>
                  </div>
                </div>
            
                <div class="col-lg-6 col-md-5 col-sm-12 order-lg-3 order-md-2 col-sm-6">
                  <div class="shorting-right">
                    <label>Urut Berdasarkan :</label>
                    <select name="_sort_by" class="ml-3" onchange="getTrainingList(1,true)">
                      @foreach(@$data_sorted_by as $key => $item)
                        <option value="{{$key}}">{{$item}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          
          <div class="row">
            
            <div class="col-lg-4 col-md-12 col-sm-12">
              <div class="page-sidebar p-0">
                <a class="filter_links" data-toggle="collapse" href="#fltbox" role="button" aria-expanded="false" aria-controls="fltbox">Buka Filter<i class="fa fa-sliders-h ml-2"></i></a>							
                <div class="collapse" id="fltbox">
                  <!-- Find New Property -->
                  <div class="sidebar-widgets p-4">
                    
                    <div class="form-group">
                      <small class="text-dark-bold-freesize">Judul</small>
                      <div class="input-with-icon">
                        <input name="_title" type="text" class="form-control input-sm" placeholder="Contoh: perikanan">
                        <i class="ti-search"></i>
                      </div>
                    </div>
                    
                    <!-- <div class="form-group mt-4">
                      <small class="text-dark-bold-freesize">Status</small>
                      <select name="_status" class="form-control input-sm">
                        <option value="">Semua</option>
                        foreach(@$legal_product_statuses as $item)
                        <option value="$item->value">$item->label</option>
                        endforeach
                      </select>
                    </div> -->
                    
                    <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12 pt-4 pb-4">
                        <small class="text-dark-bold-freesize">Tahun Dilaksanakan (<i>Range</i>)</small>
                        <div class="rg-slider">
                          <input type="text" class="js-range-slider" name="_year"/>
                        </div>
                      </div>
                    </div>		
                                  
                    <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12 pt-4">
                        <small class="text-dark-bold-freesize">Level</small>
                        <ul class="row pr-5 m-0">
                          @foreach(@$grade_levels as $item)
                          <li class="col-12 pr-2 form-check">
                            <input class="form-check-input level" type="checkbox" value="{{$item->value}}" <?php echo sizeof($get_level)?(in_array(strtoupper($item->value),$get_level)?'checked':''):'checked' ?> >
                            <label class="form-check-label"><small>{{$item->label}}</small></label>
                          </li>
                          @endforeach
                        </ul>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-4 pt-4">
                        <button onclick="resetFilter()" class="btn full-width" title="reset filter"><i class="fa fa-retweet text-warning"></i></button>
                      </div>
                      <div class="col-8 pt-4">
                        <button onclick="getTrainingList(1,true)" class="btn theme-bg rounded full-width">Cari</button>
                      </div>
                    </div>
                  
                  </div>
                </div>
              </div>		
            </div>
            
            <div class="col-lg-8 col-md-12 col-sm-12">
              <small id="filter_info"></small>
              <br><br>
              <div class="row justify-content-center" id="trainingItemPreview"></div>
            </div>
            
            
          </div>
        </div>	
			</section>
			<!-- ============================ All Property ================================== -->
			<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
		</div>
@endsection
@section('addition_script')
    <script src="{{ asset('assets/js/page.js').'?v=231018001'}}"></script>
    <script src="{{ asset('assets/js/user/training.js')}}"></script>
@endsection