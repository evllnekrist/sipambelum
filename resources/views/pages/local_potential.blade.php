@extends('layouts.app-public')
@section('title', 'Potensi Lokal')
@section('content')
    <div id="main-wrapper">    
        <!-- ============================ All Property ================================== -->
        <section class="gray pt-4">    
            <div class="container">
                <div class="row m-0">
                <div class="short_wraping">
    <div class="row align-items-center">
        <!-- Left Section -->
        <div class="col-lg-6 col-md-7 col-sm-12 order-lg-2 order-md-3 elco_bor col-sm-12">
            <div class="shorting_pagination">
                <div class="shorting_pagination_laft">
                <h5>
                    Menampilkan 
                    <span id="products_count_start">{{ ($currentPage - 1) * $pageSize + 1 }}</span> - 
                    <span id="products_count_end">{{ min($currentPage * $pageSize, $totalItems) }}</span>
                    dari <span id="products_count_total">{{ $totalItems }}</span> data
                </h5>
                    <input name="_page" value="1" hidden>
                </div>
                <div class="shorting_pagination_right">
                <ul id="_pagination" class="pagination">
                    @for ($i = 1; $i <= ceil($totalItems / $pageSize); $i++)
                        <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                            <a class="page-link" href="#" onclick="getLocalPotentialList({{ $i }}, true)">{{ $i }}</a>
                        </li>
                    @endfor
                </ul>
            </div>
            <!-- <div class="shorting_pagination_right">
                    {{ $local_potentials->links() }}
                </div> -->

            </div>
        </div>

        <!-- Right Section -->
        <div class="col-lg-6 col-md-5 col-sm-12 order-lg-3 order-md-2 col-sm-6">
            <div class="shorting-right">
            <label>Urut Berdasarkan :</label>
                                    <select name="_sort_by" class="ml-3" onchange="getLocalPotentialList(1,true)">
                                        @foreach($data_sorted_by as $key => $item)
                                            <option value="{{$key}}">{{$item}}</option>
                                        @endforeach
                                    </select>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-12 col-sm-12">
        <!-- Filter Sidebar -->
        <form action="{{ route('user.local_potential.search') }}" method="GET"> <!-- Add form action for search -->
            @csrf
        <div class="page-sidebar p-0">
            <a class="filter_links" data-toggle="collapse" href="#fltbox" role="button" aria-expanded="false" aria-controls="fltbox">Buka Filter<i class="fa fa-sliders-h ml-2"></i></a>
            <div class="collapse" id="fltbox">
                <div class="sidebar-widgets p-4">
                    <!-- <div class="form-group">
                        <small class="text-dark-bold-freesize">Judul</small>
                        <div class="input-with-icon">
                            <input name="_title" type="text" class="form-control input-sm" placeholder="Contoh: perikanan">
                            <i class="ti-search"></i>
                        </div>
                    </div> -->
                    <div class="form-group">
                    <small class="text-dark-bold-freesize">Kecamatan</small>
                    <select name="_subdistrict" class="form-control input-sm">
                        <option value="">Pilih Kecamatan</option>
                        @foreach($subdistricts as $subdistrict)
                            <option value="{{ $subdistrict->id }}">{{ $subdistrict->name }}</option>
                        @endforeach
                    </select>
                </div>
                    <div class="row">
                        <div class="col-4 pt-4">
                            <button onclick="resetFilter()" class="btn full-width" title="reset filter"><i class="fa fa-retweet text-warning"></i></button>
                        </div>
                        <div class="col-8 pt-4">
                            <button onclick="getLocalPotentialList(1, true)" class="btn theme-bg rounded full-width">Cari</button>
                        </div>
                    </div>
                </div>
            </div>
</form>
        </div>
    </div>


                    <div class="col-lg-8 col-md-12 col-sm-12">
                        <small id="filter_info"></small>
                        <br><br>
                        <div class="row justify-content-center" id="trainingItemPreview">
                            @foreach($local_potentials as $local_potential)
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                <div class="grid_agents style-2">
                                    <div class="grid_agents-wrap">
                                        <div class="fr-grid-thumb">
                                            <a href="{{ $local_potential->url_link }}">
                                            <img src="{{ asset('storage/assets/img/localpotential/' . $local_potential->img_main) }}" alt="Image" width="100">

                                            </a>
                                        </div>
                                        <div class="fr-grid-deatil">
                                            <h5 class="fr-can-name"><a href="{{ $local_potential->url_link }}">{{ $local_potential->name }}</a></h5>
                                            <button type="button" class="btn btn-success btn-sm subdistrict-details-btn" data-toggle="modal" data-target="#subdistrictDetailModal" data-subdistrict="{{ $local_potential->subdistricts->pluck('name')->implode(',') }}">
                                                Detail Kecamatan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>   
            <!-- Modal for Subdistrict Details -->
            <div class="modal fade" id="subdistrictDetailModal" tabindex="-1" role="dialog" aria-labelledby="subdistrictDetailModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="subdistrictDetailModalLabel">Detail Kecamatan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="subdistrictDetailBody">
                            <!-- Subdistrict details will be inserted here dynamically -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
    </div>
@endsection

@section('addition_script')

</script>
    <script src="{{ asset('assets/js/page.js').'?v=231018001'}}"></script>
    <script src="{{ asset('assets/js/user/localpotential.js')}}"></script>
@endsection
