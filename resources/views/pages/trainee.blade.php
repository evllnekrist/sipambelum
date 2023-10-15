@extends('layouts.app-public')
@section('title', 'Peserta Pelatihan')
@section('content')

<div id="main-wrapper">    
    <!-- ============================ All Property ================================== -->

    <section class="gray pt-4">    
        <div class="container">
        <div class="col text-center">
						<div class="sec-heading center">
							<h2>Peserta Pelatihan</h2>
							<p>Pencarian Informasi Terkait Peserta yang mengikuti Pelatihan.</p>
							<br><small id="newsItemPreview_filterInfo"></small>
						</div>
					</div>
                    <hr>
            <div class="row">
                
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="page-sidebar p-0">
                        <form method="get" action="{{ route('user.trainee') }}">
                            <div class="sidebar-widgets p-4">
                                <div class="form-group">
                                    <small class="text-dark-bold-freesize">NIK</small>
                                    <div class="input-with-icon">
                                        <input name="nik" type="text" class="form-control input-sm" placeholder="Cari Berdasarkan NIK">
                                        <i class="ti-search"></i>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 pt-4">
                                        <button type="button" onclick="resetFilterCCH()" class="btn full-width" title="reset filter"><i class="fa fa-retweet text-warning"></i></button>
                                    </div>
                                    <div class="col-8 pt-4">
                                        <button type="submit" class="btn theme-bg rounded full-width">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>        
                </div>

                <div class="col-lg-8 col-md-12 col-sm-12">
                    <small id="filter_info"></small>
                    @if(session('message'))
                        <small>{{ session('message') }}</small>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Tampilkan tabel hanya jika ada hasil pencarian -->
                    @if(isset($trainees) && count($trainees) > 0)
                        <div class="dashboard_property">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                        <th scope="col" style="width:15%">NIK</th>
                                        <th scope="col" style="width:25%">Nama</th>
                                        <th scope="col" style="width:15%">Phone</th>
                                        <th scope="col" style="width:25%">Email</th>
                                        <th scope="col" style="width:20%">Kecamatan</th>
                                        <th scope="col" style="width:20%">Detail Pelatihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="courtCaseHandlingItemPreview">
                                        <!-- Loop melalui hasil pencarian dari controller dan tampilkan di sini -->
                                        @foreach($trainees as $trainee)
                                        <tr>
                                        <td>{{ $trainee->nik }}</td>
                                        <td>{{ $trainee->name }}</td>
                                        <td>{{ $trainee->phone }}</td>
                                        <td>{{ $trainee->email }}</td>
                                        <td>{{ $trainee->subdistrict_name }}</td>
                                        <td>
                                        <button type="button" class="btn btn-primary view-details-btn"
                                                data-toggle="modal" data-target="#myModal"
                                                data-trainee-id="{{ $trainee->id }}">
                                            Lihat Detail
                                        </button>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <!-- Tampilkan pesan jika tidak ada hasil pencarian -->
                      <center>  <p>Cari Data Berdasarkan NIK KTP.</p> </center>
                    @endif
                </div>
            </div>
        </div>    
    </section>
    <!-- ============================ All Property ================================== -->
    <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Tampilkan data pelatihan di sini -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Pelatihan</th>
                            <th>Status</th>
                            <th>Hasil</th>
                        </tr>
                    </thead>
                    <tbody id="trainingHistoryBody">
                        <!-- Data pelatihan akan dimasukkan dinamis melalui JavaScript -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Inside your Blade file -->
<script>
    // Use event delegation to handle click events for dynamically added elements
    $(document).on('click', '.view-details-btn', function() {
        var traineeId = $(this).data('trainee-id');
        var modalBody = $('#myModal .modal-body tbody');
        modalBody.html('<tr><td colspan="3">Memuat...</td></tr>'); // Tambahkan pesan "Memuat..."

        $.ajax({
            url: '{{ route("get.training.history") }}',
            type: 'GET',
            data: { id_trainee: traineeId },
            success: function(data) {
                modalBody.empty(); // Hapus pesan "Memuat..." setelah mendapatkan respons dari server

                data.forEach(function(history) {
                    var status = history.active == 1 ? 'Aktif' : 'Tidak Aktif';
                    var result = history.is_passed == 1 ? 'Lulus' : 'Tidak Lulus';

                    var row = '<tr>' +
                        '<td>' + history.training_name + '</td>' +
                        '<td>' + status + '</td>' +
                        '<td>' + result + '</td>' +
                        '</tr>';

                    modalBody.append(row);
                });
            },
            error: function() {
                modalBody.html('<tr><td colspan="3">Gagal memuat data. Silakan coba lagi nanti.</td></tr>'); // Tampilkan pesan kesalahan jika permintaan AJAX gagal
            }
        });
    });
    function resetFilterCCH() {
        // Reset nilai input NIK ke kosong
        $('input[name="nik"]').val('');

        // Reset pesan pencarian dan hasil tabel
        $('#filter_info').text('');
        $('#courtCaseHandlingItemPreview').empty();

        // Semua trainees akan dimuat kembali dengan menghapus parameter nik dari URL
        window.location.href = '{{ route("user.trainee") }}';
    }
</script>


