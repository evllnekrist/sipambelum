@extends('layouts.app-public')
@section('title', 'Berita')
@section('content')
    <div id="main-wrapper">	
		<section class="gray">
		
			<div class="container">
			
				<div class="row">
					<div class="col text-center">
						<div class="sec-heading center">
							<h2>Berita</h2>
							<p>Informasi terkini terkait pelatihan di Kabupaten Katingan</p>
							<br><small id="newsItemPreview_filterInfo"></small>
						</div>
					</div>
				</div>
			
				<!-- row Start -->
				<div class="row" id="newsItemPreview"></div>
				<!-- /row -->

				<!-- Pagination -->
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<ul id="newsItemPreview_pagination" class="pagination p-center"></ul>
					</div>
				</div>				
				
			</div>
					
		</section>
		<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
	</div>
@endsection
@section('addition_script')
    <script src="{{ asset('assets/js/page.js').'?v='.date('YmdH') }}"></script>
    <script src="{{ asset('assets/js/user/news.js').'?v='.date('YmdH') }}"></script>
@endsection