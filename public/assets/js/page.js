// console.log('SHARED')

const apiHeaders = {
  "Accept": "*/*",
  "Access-Control-Allow-Origin": "*",
  "Content-Type": "multipart/form-data",
};
const formatterMonth = new Intl.DateTimeFormat('en-US', { month: 'short' });
const baseUrl = window.location.origin;
const loadingElementImg = `<div class="mx-auto"><img src="../../assets/img/loading.gif"></div>`;
const loadingElement = `<div class="mx-auto">memuat...</div>`;
moment.locale('id')

$('.nospace').on('keyup', function(event) {
  if((event.target.value).includes(' ')){
    Swal.fire({
      position: 'top-end',
      icon: 'warning',
      html: 'Input ini tidak menerima spasi',
      showConfirmButton: false,
      timer: 2000
    });
  }
  event.target.value =  event.target.value.replaceAll(" ","")
});

$('.numeric').on('keyup', function(event) {
  if ((event.target.value).match(/[^$,.\d]/)){
    Swal.fire({
      position: 'top-end',
      icon: 'warning',
      html: 'Input ini hanya boleh angka',
      showConfirmButton: false,
      timer: 2000
    });
  }
  event.target.value =  event.target.value.replace(/[^\d]+/g,'')
});

$('.uppercase').on('keyup', function(event) {
  event.target.value =  event.target.value.toUpperCase()
});

$('.lowercase').on('keyup', function(event) {
  event.target.value =  event.target.value.toLowerCase()
});

const regexExp_slug = /^[a-z][-a-z0-9]*$/;
function checkSlug(str){
  if(regexExp_slug.test(str)){
    $('#slug-info').html('<i class="text-info">Slug valid</i>');
    $('[name="check_validity"]').val(1)
  }else{
    $('#slug-info').html('<b class="text-danger">Slug tidak valid</b>');
    $('[name="check_validity"]').val(0)
  }
  // console.log('check_validity',$('[name="check_validity"]').val() )
}
$('.slug').on('keyup', function(event) {
  checkSlug(event.target.value)
});

function display(id,id2){
  // console.log(id,id2);
  let action = $('#'+id).data('display')
  if(action == 'hide'){
    $('#'+id).show()
    $('#'+id2).hide()
    $('#'+id).data('display', 'show')
    $('#'+id+'-action-text').html('Batal Ganti Gambar')
  }else{
    $('#'+id).hide()
    $('#'+id2).show()
    $('#'+id).data('display', 'hide')
    $('#'+id+'-action-text').html('Ganti Gambar')
  }
}

function copyToClipboard(copyText) {
   // Copy the text inside the text field
  navigator.clipboard.writeText(copyText);
  // Alert the copied text
  alert(`Anda sudah mengcopy: "` + copyText + `"`);
}

	// fullwidth home slider
	function inlineCSS() {
		$(".home-slider .item").each(function() {
			var attrImageBG = $(this).attr('data-background-image');
			var attrColorBG = $(this).attr('data-background-color');
			if (attrImageBG !== undefined) {
				$(this).css('background-image', 'url(' + attrImageBG + ')');
			}
			if (attrColorBG !== undefined) {
				$(this).css('background', '' + attrColorBG + '');
			}
		});
	}

  function hideLoading(appendTo){
    // console.log(appendTo+'Loading','toHide')
    $(appendTo+'Loading').hide()
  }

  function getStatistics_traineeOfTraining(){
    let payload = {}; let appendTo = '#statisticsHomepageInfo';
    axios.post(baseUrl+'/api/get-statistics-trainee-of-training', payload, apiHeaders)
    .then(function (response) {
      // console.log('[HOMEPAGE STATISTICS] response..',response);
      if(response.data.status && response.data.data) {
        $('#count_training').html(response.data.data.training.count);
        $('#count_beginner').html(response.data.data.trainee.count_beginner);
        $('#count_intermediate').html(response.data.data.trainee.count_mid);
        $('#count_advance').html(response.data.data.trainee.count_adv);
      }else{
        // swallalert here
        $(appendTo).html(`<center><b class="text-warning">Gagal mendapatkan data (C1)</b></center>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo).html(`<center><b class="text-warning">Gagal mendapatkan data (C2)</b><br><small>`+error.message+`</small>`);
    });
  }

  function getBannerList(appendTo=''){
    let payload = {page: 1, page_size: 3};
    axios.post(baseUrl+'/api/get-banner-list', payload, apiHeaders)
    .then(function (response) {
      // console.log('[BANNER] response..',response);
      let template = '';
      if(response.data.status) {
        if(appendTo){
          if(response.data.data && response.data.data.length > 0) {
            // let i = 0;
            (response.data.data).forEach((item) => {
              template +=`<div data-background-image="`+item.img_main+`" class="item">
                              <div class="container">
                                  <div class="row">
                                      <div class="col-md-12">
                                          <div class="home-slider-container">
                                              <div class="home-slider-desc">
                                                  <div class="home-slider-title">
                                                      <h3>`+(item.title?item.title:``)+`<span class="trans_text"></span></h3>
                                                      <h5 class="offers_tags">`+(item.subtitle?item.subtitle:'')+`</h5>
                                                  </div>`;
              if(item.button_title){
                template +=`<a href="`+item.button_link+`" class="read-more theme-bg">`+item.button_title+`<i class="fa fa-arrow-right ml-2"></i></a>`;
              }
              template +=`
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>`;
              // i++;
            });
            $(appendTo).html(template);
          }else{
            $(appendTo).html(`<center><b class="text-warning">tidak ada data</b></center>`);
          }
        }
      }else{
        // swallalert here
        $(appendTo).html(`<center><b class="text-warning">Gagal mendapatkan data (C1)</b></center>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo).html(`<center><b class="text-warning">Gagal mendapatkan data (C2)</b><br><small>`+error.message+`</small>`);
    });
  }

  function getNewsList(page=1,page_size=3,withPagination=false){
    let appendTo = '#newsItemPreview';
    $(appendTo).html(loadingElementImg);
    let payload = {page:page, page_size:page_size};
    axios.post(baseUrl+'/api/get-news-list', payload, apiHeaders)
    .then(function (response) {
      // console.log('[NEWS] response..',response);
      let template = '';
      if(response.data.status) {
        // i::data pagination----------------------------------------------------------------------------START
          if(withPagination){
            let max_page = Math.ceil(response.data.data_count_total/page_size);
            if(page >= 1){
              template += `
              <li class="page-item">
                <a class="page-link" onclick="getNewsList(1,`+page_size+`,`+withPagination+`)" aria-label="Pertama">
                <span class="ti-arrow-left"></span>
                <span class="sr-only">Pertama</span>
                </a>
              </li>`;
            }
            if(page-1 >= 1){
              template += `<li class="page-item"><a class="page-link" onclick="getNewsList(`+(page-1)+`,`+page_size+`,`+withPagination+`)">`+(page-1)+`</a></li>`;
            }
            template += `<li class="page-item active"><a class="page-link" onclick="getNewsList(`+(page)+`,`+page_size+`,`+withPagination+`)">`+(page)+`</a></li>`;
            if(page+1 <=  max_page){
              template += `<li class="page-item"><a class="page-link" onclick="getNewsList(`+(page+1)+`,`+page_size+`,`+withPagination+`)">`+(page+1)+`</a></li>`;
            }
            if(page < max_page){
              template += `
              <li class="page-item">
                <a class="page-link" onclick="getNewsList(`+(max_page)+`,`+page_size+`,`+withPagination+`)" aria-label="Terakhir">
                <span class="ti-arrow-right"></span>
                <span class="sr-only">Terakhir</span>
                </a>
              </li>`;
            }
            $(appendTo+'_pagination').html(template);
            $(appendTo+'_filterInfo').html(`Menampilkan `+response.data.data_count_start+`-`+response.data.data_count_end+` dari `+response.data.data_count_total+` data`);
          }
        // i::data pagination------------------------------------------------------------------------------END
        // i::data display-------------------------------------------------------------------------------START
          template = '';
          if(response.data.data && response.data.data.length > 0) {
            // let i = 0;
            (response.data.data).forEach((item) => {
              let postDateFull = new Date(item.post_at);
              let postDate = postDateFull.getDate();
              let postMonthYear = formatterMonth.format(postDateFull)+" "+postDateFull.getFullYear();
              // let profileToDisplay = baseUrl+'/no-profile.jpg'
              let imgToDisplay = baseUrl+'/assets/img/no-image-clean.png'
              let img = new Image();
              img.src = item.img_main+"?_="+(new Date().getTime());
              img.onload = function () {
                imgToDisplay = item.img_main
                $('#news_'+item.id+'_img').attr("src",imgToDisplay)
              }
              // console.log(item.img_author==null,profileToDisplay)
              template +=`<div class="col-lg-3 col-md-4">
                            <div class="grid_blog_box">
                              
                              <div class="gtid_blog_thumb">
                                <a href="blog-detail.html"><img id="news_`+item.id+`_img" src="`+imgToDisplay+`" class="img-fluid" alt="" /></a>
                                <div class="gtid_blog_info"><span>`+postDate+`</span>`+postMonthYear+`</div>
                              </div>								
                              
                              <div class="blog-body">
                                <h4 class="bl-title">
                                  <a href="`+baseUrl+`/news/`+item.slug+`" class="line-clamp-wrap line-clamp-2">`+item.title+`</a>
                                </h4>
                                <p><small class="line-clamp-wrap line-clamp-3">`+item.caption+`</small></p>
                              </div>
                              
                              <div class="modern_property_footer">
                                <div class="property-author">
                                  <h5>`+item.author+`</h5>
                                </div>
                                <span class="article-pulish-date">
                                </span>
                              </div>
                              
                            </div>
                          </div>`;
              // i++;
            });
            $(appendTo).html(template);
          }else{
            $(appendTo).html(`<center><b class="text-warning">tidak ada data</b></center>`);
          }
        // i::data display-------------------------------------------------------------------------------START
      }else{
        // swallalert here
        $(appendTo).html(`<center><b class="text-warning">Gagal mendapatkan data (C1)</b></center>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo).html(`<center><b class="text-warning">Gagal mendapatkan data (C2)</b><br><small>`+error.message+`</small>`);
    });
  }

  function getTrainingList(page=1,page_size=3,withPagination=false){
    let appendTo = '#trainingItemPreview';
    $(appendTo).html(loadingElementImg);
    let payload = {page:page, page_size:page_size};
    axios.post(baseUrl+'/api/get-training-list', payload, apiHeaders)
    .then(function (response) {
      // console.log('[TRAINING] response..',response);
      let template = '';
      if(response.data.status) {
        // i::data pagination----------------------------------------------------------------------------START
          if(withPagination){
            let max_page = Math.ceil(response.data.data_count_total/page_size);
            if(page >= 1){
              template += `
              <li class="page-item">
                <a class="page-link" onclick="getTrainingList(1,`+page_size+`,`+withPagination+`)" aria-label="Pertama">
                <span class="ti-arrow-left"></span>
                <span class="sr-only">Pertama</span>
                </a>
              </li>`;
            }
            if(page-1 >= 1){
              template += `<li class="page-item"><a class="page-link" onclick="getTrainingList(`+(page-1)+`,`+page_size+`,`+withPagination+`)">`+(page-1)+`</a></li>`;
            }
            template += `<li class="page-item active"><a class="page-link" onclick="getTrainingList(`+(page)+`,`+page_size+`,`+withPagination+`)">`+(page)+`</a></li>`;
            if(page+1 <=  max_page){
              template += `<li class="page-item"><a class="page-link" onclick="getTrainingList(`+(page+1)+`,`+page_size+`,`+withPagination+`)">`+(page+1)+`</a></li>`;
            }
            if(page < max_page){
              template += `
              <li class="page-item">
                <a class="page-link" onclick="getTrainingList(`+(max_page)+`,`+page_size+`,`+withPagination+`)" aria-label="Terakhir">
                <span class="ti-arrow-right"></span>
                <span class="sr-only">Terakhir</span>
                </a>
              </li>`;
            }
            $(appendTo+'_pagination').html(template);
            $(appendTo+'_filterInfo').html(`Menampilkan `+response.data.data_count_start+`-`+response.data.data_count_end+` dari `+response.data.data_count_total+` data`);
          }
        // i::data pagination------------------------------------------------------------------------------END
        // i::data display-------------------------------------------------------------------------------START
          template = '';
          if(response.data.data && response.data.data.length > 0) {
            // let i = 0;
            (response.data.data).forEach((item) => {
              let imgToDisplay = baseUrl+'/assets/img/no-image-clean.png'
              let img = new Image();
              img.src = item.img_main+"?_="+(new Date().getTime());
              img.onload = function () {
                imgToDisplay = item.img_main
                $('#training_'+item.id+'_img').attr("src",imgToDisplay)
              }
              // console.log(item.img_author==null,profileToDisplay)
              template +=`<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                            <div class="grid_agents style-2">

                              <div class="grid_agents-wrap">
                                <div class="fr-grid-thumb">
                                  <a href="agent-page.html">
                                    <img id="training_`+item.id+`_img" src="`+imgToDisplay+`" class="img-fluid mx-auto my-auto" alt="">
                                  </a>
                                  <ul class="inline_social">
                                    <li>
                                      <a href="#"><i class="fa fa-info" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                      <a class="trainingItemPreviewTooltips" data-toggle="tooltip" data-html="true" title="<em>Alamat:</em><br>`+item.address+`">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                      </a>
                                    </li>
                                    <li>
                                      <a class="trainingItemPreviewTooltips" data-toggle="tooltip" data-html="true" title="<em>Email:</em><br>`+item.contact_email+`">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                      </a>
                                    </li>
                                    <li>
                                      <a class="trainingItemPreviewTooltips" data-toggle="tooltip" data-html="true" title="<em>Telepon/WA:</em><br>`+item.contact_phone+`">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                      </a>
                                    </li>
                                  </ul>
                                </div>
                                
                                <div class="fr-grid-deatil">
                                  <div class="mb-2">
                                  `+(item.is_online?
                                    `<b class="badge badge-warning">Online</b>`:
                                    `<b class="badge badge-success">Offline</b>`)
                                  +`
                                  </div>
                                  <h5 class="fr-can-name"><a href="`+baseUrl+`/training/`+item.slug+`">`+item.name+`</a></h5>
                                  <small>`+moment(item.event_start).format('DD MMM YYYY, h:mm:ss a')+` s/d<br>`+moment(item.event_end).format('DD MMM YYYY, h:mm:ss a')+`</small>
                                </div>
                              </div>

                            </div>
                          </div>`;
              // i++;
            });
            $(appendTo).html(template);
            $('.trainingItemPreviewTooltips').tooltip();
          }else{
            $(appendTo).html(`<center><b class="text-warning">tidak ada data</b></center>`);
          }
        // i::data display-------------------------------------------------------------------------------START
      }else{
        // swallalert here
        $(appendTo).html(`<center><b class="text-warning">Gagal mendapatkan data (C1)</b></center>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo).html(`<center><b class="text-warning">Gagal mendapatkan data (C2)</b><br><small>`+error.message+`</small>`);
    });
  }

  function showDisplayVideo(src,title,desc){
    // console.log(src,title,desc)
    $('#display-video-file').html(`<iframe width="100%" height="315"
                                    src="`+src+`" 
                                    title="YouTube video player" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    allowfullscreen>
                                  </iframe>`);
    $('#display-video-title').html(title)
    $('#display-video-desc').html(desc)
  }

  function getGalleryList(page=1,page_size=3,withPagination=false){
    let appendTo = '#galleryItemPreview';
    $(appendTo).html(loadingElement);
    let payload = {page:page, page_size:page_size};
    axios.post(baseUrl+'/api/get-gallery-list', payload, apiHeaders)
    .then(function (response) {
      // console.log('[GALLERY] response..',response);
      let template = '';
      if(response.data.status) {
        // i::data pagination----------------------------------------------------------------------------START
          if(withPagination){
            let max_page = Math.ceil(response.data.data_count_total/page_size);
            if(page >= 1){
              template += `
              <li class="page-item">
                <a class="page-link" onclick="getGalleryList(1,`+page_size+`,`+withPagination+`)" aria-label="Pertama">
                <span class="ti-arrow-left"></span>
                <span class="sr-only">Pertama</span>
                </a>
              </li>`;
            }
            if(page-1 >= 1){
              template += `<li class="page-item"><a class="page-link" onclick="getGalleryList(`+(page-1)+`,`+page_size+`,`+withPagination+`)">`+(page-1)+`</a></li>`;
            }
            template += `<li class="page-item active"><a class="page-link" onclick="getGalleryList(`+(page)+`,`+page_size+`,`+withPagination+`)">`+(page)+`</a></li>`;
            if(page+1 <=  max_page){
              template += `<li class="page-item"><a class="page-link" onclick="getGalleryList(`+(page+1)+`,`+page_size+`,`+withPagination+`)">`+(page+1)+`</a></li>`;
            }
            if(page < max_page){
              template += `
              <li class="page-item">
                <a class="page-link" onclick="getGalleryList(`+(max_page)+`,`+page_size+`,`+withPagination+`)" aria-label="Terakhir">
                <span class="ti-arrow-right"></span>
                <span class="sr-only">Terakhir</span>
                </a>
              </li>`;
            }
            $(appendTo+'_pagination').html(template);
            $(appendTo+'_filterInfo').html(`Menampilkan `+response.data.data_count_start+`-`+response.data.data_count_end+` dari `+response.data.data_count_total+` data`);
          }
        // i::data pagination------------------------------------------------------------------------------END
        // i::data display-------------------------------------------------------------------------------START
          template = '';
          if(response.data.data && response.data.data.length > 0) {
            // let i = 0;
            (response.data.data).forEach((item) => {
              let postDateFull = new Date(item.created_at);
              let postDate = postDateFull.getDate();
              let postMonthYear = formatterMonth.format(postDateFull)+" "+postDateFull.getFullYear();
              let imgToDisplay = baseUrl+'/assets/img/no-image-clean.png'
              let img = new Image();
              img.src = item.img_main+"?_="+(new Date().getTime());
              img.onload = function () {
                imgToDisplay = item.img_main
                $('#gallery_'+item.id+'_img').attr("src",imgToDisplay)
              }
              template +=`<div class="col-lg-4 col-md-6">`;     
              if(item.media_type == 'video'){
                template +=`<a class="img-wrap" href="#" data-toggle="modal" data-target="#display-video" onclick="showDisplayVideo('`+item.media_main+`','`+item.title+`','`+item.desc+`')">
                              <i class="fas fa-user-circle fa-lg"></i>`;
              }else{  
                template +=`<a class="img-wrap" href="`+item.media_main+`" data-title="`+item.desc+`" data-lightbox="roadtrip">`;
              }
              template +=`
                                <div class="location_wrap_content visible">
                                  <div class="location_wrap_content_first">
                                    <h6>`+item.title+`</h6>
                                    <span>`+postDate+` `+postMonthYear+`</span>
                                  </div>
                                  <div class="location_btn"><i class="fa fa-arrow-right"></i></div>
                                </div>`;
              if(item.media_type == 'video'){
                template +=`<div class="img-wrap-background">
                              <iframe width="560" height="315" src="`+item.media_main+`" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen>
                              </iframe>
                            </div>`;
              }else{
                template +=`<div class="img-wrap-background" style="background-image: url(`+item.media_main+`);"></div>`;
              }
              template +=`
                            </a>
                          </div>`;
              // i++;
            });
            $(appendTo).html(template);
          }else{
            $(appendTo).html(`<center><b class="text-warning">tidak ada data</b></center>`);
          }
        // i::data display-------------------------------------------------------------------------------START
      }else{
        // swallalert here
        $(appendTo).html(`<center><b class="text-warning">Gagal mendapatkan data (C1)</b></center>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo).html(`<center><b class="text-warning">Gagal mendapatkan data (C2)</b><br><small>`+error.message+`</small>`);
    });
  }

  function getSelectionList(appendTo='',type='',style='min'){
    let payload = {type: type};
    axios.post(baseUrl+'/api/get-selection-list', payload, apiHeaders)
    .then(function (response) {
      // console.log('[SELECTION LIST] response..',response);
      let template = '';
      if(response.data.status) {
        if(appendTo){
          if(response.data.data && response.data.data.length > 0) {
            if(style == 'min'){
              // let i = 0;
              (response.data.data).forEach((item) => {
                template +=`<div class="col-lg-3 col-md-4 col-xs-6">
                              <div class="property_cats_boxs">
                                <div class="category-box `+(item.value2=='dark'?`bg-dark-web`:``)+`" title="`+item.label+`">
                                  <a href="`+item.url_link+`" target="_blank" class="property_category_short">
                                    <div class="kategori-icon m-2">
                                      <img src="`+item.img_main+`" class="logoservice" alt="" />
                                    </div>
                                  </a>
                                </div>	
                              </div>
                            </div>`;
                // i++;
              });
            }else{
              // let i = 0;
              (response.data.data).forEach((item) => {
                template +=`<div class="col-lg-4 col-md-6">
                              <div class="property_cats_boxs">
                                <a href="`+item.url_link+`" target="_blank" class="category-box">
                                  <div class="property_category_short">
                                    <div class="kategori-icon m-4">
                                      <img src="`+item.img_main+`" class="logofitur" alt="" />
                                    </div>

                                    <div class="property_category_expand property_category_short-text">
                                      <h4>`+item.label+`</h4>
                                      <p>`+item.desc+`</p>
                                    </div>
                                  </div>
                                </a>	
                              </div>
                            </div>`;
                // i++;
              });
            }
            $(appendTo).html(template);
          }else{
            $(appendTo).html(`<center><b class="text-warning">tidak ada data</b></center>`);
          }
        }
      }else{
        // swallalert here
        $(appendTo).html(`<center><b class="text-warning">Gagal mendapatkan data (C1)</b></center>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo).html(`<center><b class="text-warning">Gagal mendapatkan data (C2)</b><br><small>`+error.message+`</small>`);
    });
  }
  
  let product_sorted_by = {
    'latest'            : 'Paling Baru Ditambahkan',
    'abc'               : 'Alfabet Judul A-Z',
    'abc-reverse'       : 'Alfabet Judul Z-A',
    'most_viewed'       : 'Paling Banyak Dilihat',
    'most_downloaded'   : 'Paling Banyak Diunduh',
    // 'most_reviewed'     : 'Paling Banyak Direview',
    // 'top_review'        : 'Review Tertinggi'
  };

  // function addCount(id,act,type){
  //   axios.get(baseUrl+'/api/'+type+'/post-act/'+id+'/'+act, [], apiHeaders)
  //   .then(function (response) {
  //     console.log('[add '+act+' count of '+type+'] response..',response);
  //     // if(response.data.status) {
       
  //     // }else{
  //     //   // swallalert here
  //     // }
  //   })
  //   .catch(function (error) {
  //     // swallalert here
  //   });
  // }