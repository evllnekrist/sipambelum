@extends('layouts.app-public')
@section('title', 'Berita')
@section('body-class', 'blog-page')
@section('content')
    <div id="main-wrapper">	
			
			<!-- ============================ Agency List Start ================================== -->
			<section class="gray">
				<div class="container">
					<!-- row Start -->
					<div class="row">
						<!-- Blog Detail -->
						<div class="col-lg-8 col-md-12 col-sm-12 col-12">
							<div class="article_detail_wrapss single_article_wrap format-standard">
								<div class="article_body_wrap">
								
									<div class="article_featured_image">
										<img class="img-fluid" src="{{@$selected->img_main}}" alt="">
									</div>
									
									<div class="article_top_info">
										<ul class="article_middle_info">
											<li><a href="#"><span class="icons"><i class="ti-user"></i></span>oleh {{@$selected->author}}</a></li>
											<!-- <li><a href="#"><span class="icons"><i class="ti-comment-alt"></i></span>Comments</a></li> -->
										</ul>
									</div>
									<h2 class="post-title">{{@$selected->title}}</h2>
                                    <div class="mt-5">{!!@$selected->content!!}</div>
								</div>
							</div>
						</div>
						<!-- Single blog Grid -->
						<div class="col-lg-4 col-md-12 col-sm-12 col-12">
							
							<!-- Searchbard -->
							<div class="single_widgets widget_search">
								<h4 class="title">Cari...</h4>
								<form action="#" class="sidebar-search-form">
									<input type="search" name="search" placeholder="Search..">
									<button type="submit"><i class="ti-search"></i></button>
								</form>
							</div>
							<!-- keywords Cloud -->
                            <?php
                                $keywords = explode(",",$selected->keywords);
                            ?>
							<div class="single_widgets widget_tags">
								<h4 class="title">Kata Kunci Terkait</h4>
								<ul>
                                    @foreach($keywords as $keyword)
                                        <li><a href="{{route('user.news').'?keyword='.$keyword}}" target="_blank">{{$keyword}}</a></li>
                                    @endforeach
								</ul>
							</div>
                            <!-- Trending Posts -->
                            <div class="single_widgets widget_thumb_post">
                                <h4 class="title">Berita Lainnya</h4>
                                <ul>
                                @foreach($news as $item)
                                <li>
                                    <span class="left">
                                    <img src="{{@$item->img_main}}" alt="" class="">
                                    </span>
                                    <span class="right">
                                    <a class="feed-title" href="{{route('user.news').'/'.@$item->slug}}">{{@$item->title}}</a> 
                                    <span class="post-date"><i class="ti-calendar"></i>{{@$item->created_at}}</span>
                                    </span>
                                </li>
                                @endforeach
                                </ul>
                            </div>
						</div>
					</div>
					<!-- /row -->	
				</div>
			</section>
			<!-- ============================ Agency List End ================================== -->
			<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
		</div>
@endsection
@section('addition_script')
    <!-- <script src="{{ asset('assets/js/page.js').'?v='.date('YmdH').'2' }}"></script> -->
    <!-- <script src="{{ asset('assets/js/user/legal-product.js').'?v='.date('YmdH') }}"></script> -->
@endsection