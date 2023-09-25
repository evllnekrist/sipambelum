@extends('layouts.app-public')
@section('title', 'Home')
@section('content')
    <div id="main-wrapper">	
        
			<section class="gray pt-5 pb-5">
				<div class="container-fluid">
								
					<div class="row">
						
						<div class="col-lg-3 col-md-4 col-sm-12">
							<div class="property_dashboard_navbar">
								
								<div class="dash_user_avater">
									<img src="https://via.placeholder.com/400x400" class="img-fluid avater" alt="">
									<h4>{{Auth::user()->name}}</h4>
									<span>{{Auth::user()->role}}</span>
								</div>
								
								<div class="dash_user_menues">
									<ul>
										<li>
                                            <a href="{{route('admin.training')}}">
                                                <i class="fa fa-bookmark"></i>Pelatihan
                                            </a>
                                        </li>
										<li>
                                            <a href="{{route('admin.trainee')}}">
                                                <i class="fa fa-bookmark"></i>Peserta
                                            </a>
                                        </li>
										<li>
                                            <a href="{{route('admin.business')}}">
                                                <i class="fa fa-bookmark">Bisnis</i>
                                            </a>
                                        </li>
										<li>
                                            <a href="{{route('admin.local-potential')}}">
                                                <i class="fa fa-bookmark">Potensi Lokal</i>
                                            </a>
                                        </li>
										<li>
                                            <a href="{{route('admin.page')}}">
                                                <i class="fa fa-bookmark">Halaman</i>
                                            </a>
                                        </li>
										<li>
                                            <a href="{{route('admin.banner')}}">
                                                <i class="fa fa-bookmark">Banner</i>
                                            </a>
                                        </li>
										<li>
                                            <a href="{{route('admin.news')}}">
                                                <i class="fa fa-bookmark">Berita</i>
                                            </a>
                                        </li>
										<li>
                                            <a href="{{route('admin.user')}}">
                                                <i class="fa fa-bookmark">Pengguna</i>
                                            </a>
                                        </li>
									</ul>
								</div>
								
								<div class="dash_user_footer">
									<ul>
										<li><a href="#"><i class="fa fa-power-off"></i></a></li>
										<li><a href="#"><i class="fa fa-cog"></i></a></li>
									</ul>
								</div>
								
							</div>
						</div>
						
						<div class="col-lg-9 col-md-8 col-sm-12">
							<div class="dashboard-body">
							
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="_prt_filt_dash">
											<div class="_prt_filt_dash_flex">
												<div class="foot-news-last">
													<div class="input-group">
													  <input type="text" class="form-control" placeholder="Email Address">
														<div class="input-group-append">
															<span type="button" class="input-group-text bg-danger border-0 text-light"><i class="fas fa-search"></i></span>
														</div>
													</div>
												</div>
											</div>
											<div class="_prt_filt_dash_last m2_hide">
												<div class="_prt_filt_radius">
													
												</div>
												<div class="_prt_filt_add_new">
													<a href="submit-property-dashboard.html" class="prt_submit_link"><i class="fas fa-plus-circle"></i><span class="d-none d-lg-block d-md-block">List New Property</span></a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="dashboard_property">
											<div class="table-responsive">
												<table class="table">
													<thead class="thead-dark">
														<tr>
														  <th scope="col">Property</th>
														  <th scope="col" class="m2_hide">Leads</th>
														  <th scope="col" class="m2_hide">Stats</th>
														  <th scope="col" class="m2_hide">Posted On</th>
														  <th scope="col">Status</th>
														  <th scope="col">Action</th>
														</tr>
													</thead>
													<tbody>
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="https://via.placeholder.com/800x550" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="active">Active</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="https://via.placeholder.com/800x550" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="expire">Expired</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="https://via.placeholder.com/800x550" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="active">Active</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="https://via.placeholder.com/800x550" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="expire">Expired</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="https://via.placeholder.com/800x550" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="active">Active</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="https://via.placeholder.com/800x550" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="active">Active</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="https://via.placeholder.com/800x550" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="expire">Expired</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="https://via.placeholder.com/800x550" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="active">Active</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="https://via.placeholder.com/800x550" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="expire">Expired</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!-- row -->
							
								
							</div>
								
						</div>
						
					</div>
				</div>
			</section>
    </div>
@endsection
@section('addition_script')
    <script src="{{ asset('assets/js/page.js').'?v=230924001' }}"></script>
@endsection