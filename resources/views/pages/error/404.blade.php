@extends('layouts.app-public')
@section('title', 'Sipambelum')
@section('content')
    <div id="main-wrapper">	
			<!-- ============================ User Dashboard ================================== -->
			<section class="error-wrap">
				<div class="container">
					<div class="row justify-content-center">
						
						<div class="col-lg-6 col-md-10">
							<div class="text-center">
								
								<img src="{{asset('assets/img/404_enggang.png')}}" class="img-fluid" style="height:40vh" alt="">
								<h3 class="text-secondary mt-5 mb-3">Halaman yang Anda cari tidak tersedia</h3>
								<a class="text-success" href="{{url('/')}}"><b>Kembali ke <i class="ti-home"></i></b></a>
								
							</div>
						</div>
						
					</div>
				</div>
			</section>
			<!-- ============================ User Dashboard End ================================== -->
			<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
		</div>
@endsection
@section('addition_script')
    <!-- <script src="{{ asset('assets/js/page.js').'?v='.date('YmdH').'2' }}"></script> -->
    <!-- <script src="{{ asset('assets/js/user/legal-product.js').'?v='.date('YmdH') }}"></script> -->
@endsection