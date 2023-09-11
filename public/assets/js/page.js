// console.log('SHARED')

const apiHeaders = {
  "Accept": "*/*",
  "Access-Control-Allow-Origin": "*",
  "Content-Type": "multipart/form-data",
};
const formatterMonth = new Intl.DateTimeFormat('en-US', { month: 'short' });
const baseUrl = window.location.origin;
const loadingElementImg = `<div class="mx-auto"><img src="../../loading-unscreen.gif"></div>`;
const loadingElement = `<div class="mx-auto">memuat...</div>`;

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
        $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C1)</b>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C2)</b>`);
    });
  }

  function getStatistics_LegalProduct_ByType(appendTo=''){
    let payload = {};
    axios.post(baseUrl+'/api/get-statistics-legal-products-by-type', payload, apiHeaders)
    .then(function (response) {
      // console.log('[LP STATISTICS] response..',response);
      let template = '';
      if(response.data.status) {
        if(appendTo){
          if(response.data.data && response.data.data.length > 0) {
            // let i = 0;
            (response.data.data).forEach((item) => {
              template += `<div class="col-lg-4 col-md-6">
                            <div class="property_cats_boxs">
                              <a href="`+item.legal_product_type_attr.url_link+`" target="_blank" class="category-box">
                                <div class="property_category_short">
                                  <div class="kategori-icon">
                                    <img src="`+(assetUrl+item.legal_product_type_attr.img_main)+`" class="logofitur" alt="" />
                                  </div>

                                  <div class="property_category_expand property_category_short-text">
                                    <h4>`+item.legal_product_type_attr.label+`</h4>
                                    <p>`+item.total+` Data</p>
                                  </div>
                                </div>
                              </a>	
                            </div>
                          </div>`;
              // i++;
            });
            $(appendTo).html(template);
          }else{
            $(appendTo).html(`<b class="text-warning">tidak ada data</b>`);
          }
        }
      }else{
        // swallalert here
        $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C1)</b>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C2)</b>`);
    });
  }
  
  function getStatistics_LegalProduct_ByTime(appendTo=''){;
    let payload = {};
    axios.post(baseUrl+'/api/get-statistics-legal-products-by-time', payload, apiHeaders)
    .then(function (response) {
      // console.log('[LP STATISTICS] response..',response);
      if(response.data.status) {
        if(appendTo){
          if(response.data.data) {  
            // const data2 = [
            //   { year: 2010, count: 10 },
            //   { year: 2011, count: 20 },
            //   { year: 2012, count: 15 },
            //   { year: 2013, count: 25 },
            //   { year: 2014, count: 22 },
            //   { year: 2015, count: 30 },
            //   { year: 2016, count: 28 },
            // ];
            const data = response.data.data        
            let label = []
            let dataset = []
            var objMap = new Map(Object.entries(data['lps'])) // caching map
            // console.log('objMap',objMap)
            objMap.forEach((item, key) => { // fast iteration on Map object
              if(!(label.includes(item.year))){
                label.push(item.year)
              }
            })
            let thisYearNullData = true
            for (let index = 0; index < data['lpt'].length; index++) {
                dataset[index] = {
                  label: data['lpt'][index]['value'],
                  data: []
                }
                label.forEach(year => {
                  thisYearNullData = true
                  objMap.forEach((item, key) => { // fast iteration on Map object
                    if(item.legal_product_type == data['lpt'][index]['value'] && item.year == year){
                      dataset[index]['data'].push(item.total)
                      thisYearNullData = false
                    }
                  })
                  if(thisYearNullData){
                    dataset[index]['data'].push(0)
                  }
                })
            }
            // console.log('data',data)
            // console.log('label',label)
            // console.log('dataset',dataset)
            // console.log('[EXPECTED] data',data2)
            // console.log('[EXPECTED] label',data2.map(row => row.year))
            // console.log('[EXPECTED] dataset',[
            //       {
            //         label: 'Acquisitions by year',
            //         data: data2.map(row => row.count)
            //       }
            //     ])
            new Chart(
              $(appendTo+'Canvas'),
              {
                type: 'bar',
                data: {
                  labels: label,
                  datasets: dataset
                },
                options: {
                  maintainAspectRatio: false,
                  responsive: true,
                  plugins: {
                    legend: {
                      position: 'top',
                    },
                    title: {
                      display: true,
                      text: 'Grafik jumlah produk hukum di wilayah Kabupaten Katingan per tahun'
                    },
                  },
                },
              }
            );
          }else{
            $(appendTo).html(`<b class="text-warning">tidak ada data</b>`);
          }
          hideLoading(appendTo)
        }
      }else{
        // swallalert here
        $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C1)</b>`);
        hideLoading(appendTo)
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C2)</b>`);
      hideLoading(appendTo)
    });
  }

  function getStatistics_Visitor_ByTime(appendTo=''){;
    let payload = {};
    axios.post(baseUrl+'/api/get-statistics-visitor-by-time', payload, apiHeaders)
    .then(function (response) {
      // console.log('[VISITOR STATISTICS] response..',response);
      let template = '';
      if(response.data.status) {
        if(appendTo){
          if(response.data.data) {
            let data = response.data.data
            template += `<div class="col-lg-3 col-md-6 col-sm-12">
                          <div class="dashboard_stats_wrap widget-1">
                            <div class="dashboard_stats_wrap_content">
                              <h4>`+data.in_a_year.total+`</h4> 
                              <span>Pengunjung<br>Setahun Terakhir</span><br>
                              <small>(`+data.in_a_year.start+` sd `+data.in_a_month.end+`)</small>
                            </div>
                            <div class="dashboard_stats_wrap-icon">
                              <i class="fa fa-sun"></i>
                            </div>
                          </div>	
                        </div>`;
            template += `<div class="col-lg-3 col-md-6 col-sm-12">
                          <div class="dashboard_stats_wrap widget-2">
                            <div class="dashboard_stats_wrap_content">
                              <h4>`+data.in_a_month.total+`</h4> 
                              <span>Pengunjung<br>Sebulan Terakhir</span><br>
                              <small>(`+data.in_a_month.start+` sd `+data.in_a_month.end+`)</small>
                            </div>
                            <div class="dashboard_stats_wrap-icon">
                              <i class="fa fa-moon"></i>
                            </div>
                          </div>	
                        </div>`;
            template += `<div class="col-lg-3 col-md-6 col-sm-12">
                          <div class="dashboard_stats_wrap widget-3">
                            <div class="dashboard_stats_wrap_content">
                              <h4>`+(data.yesterday?data.yesterday.total:'0')+`</h4> 
                              <span>Pengunjung<br>Kemarin</span><br>
                              <small>(`+(data.yesterday?data.yesterday.date:new Date((new Date()).setDate((new Date()).getDate() - 1)).toISOString().slice(0,10))+`)</small>
                            </div>
                            <div class="dashboard_stats_wrap-icon">
                              <i class="fas fa-star"></i>
                            </div>
                          </div>	
                        </div>`;
            template += `<div class="col-lg-3 col-md-6 col-sm-12">
                          <div class="dashboard_stats_wrap widget-3">
                            <div class="dashboard_stats_wrap_content">
                              <h4>`+(data.today?data.today.total:0)+`</h4> 
                              <span>Pengunjung<br>Hari Ini</span><br>
                              <small>(`+(data.today?data.today.date:(new Date()).toISOString().slice(0,10))+`)</small>
                            </div>
                            <div class="dashboard_stats_wrap-icon">
                              <i class="fa fa-star-half"></i>
                            </div>
                          </div>	
                        </div>`;
            $(appendTo).html(template);
          }else{
            $(appendTo).html(`<b class="text-warning">tidak ada data</b>`);
          }
        }
      }else{
        // swallalert here
        $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C1)</b>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C2)</b>`);
    });
  }

  function getStatistics_Satisfaction(appendTo=''){
    $(appendTo+'_info').html(loadingElement);
    let payload = {};
    axios.post(baseUrl+'/api/get-statistics-satisfaction', payload, apiHeaders)
    .then(function (response) {
      console.log('[SATISFACTION STATISTICS] response..',response.data);
      if(response.data.status) {
        if(appendTo){
          if(response.data.data) {
            var table = $(appendTo).DataTable({ // https://datatables.net/manual/data/
              dom: 'Bfrtip',
              data: response.data.data,
              columns: [ 
                { data: 'id'},
                { data: 'name' },
                { data: 'star' },
                { data: null, render: function ( data, type, row ) { // https://editor.datatables.net/examples/api/triggerButton.html
                    return '<strong>'+data.title+'</strong><p>'+data.desc+'</p>';
                  } 
                },
              ],
            });

            table.on('order.dt search.dt', function () {
                var i = 1;
  
                table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                    this.data(i++);
                });
            })
            .draw();
          }else{
            $(appendTo+'_info').html(`<b class="text-warning">tidak ada data</b>`);
          }
        }
      }else{
        // swallalert here
        $(appendTo+'_info').html(`<b class="text-warning">Gagal mendapatkan data (C1)</b>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo+'_info').html(`<b class="text-warning">Gagal mendapatkan data (C2)</b>`);
    });
  }

  function getStatistics_Satisfaction_Summary(appendTo=''){;
    let payload = {};
    axios.post(baseUrl+'/api/get-statistics-satisfaction_summary', payload, apiHeaders)
    .then(function (response) {
      console.log('[SATISFACTION STATISTICS] response..',response.data);
      let template = ``;
      if(response.data.status) {
        if(appendTo){
          if(response.data.data) {
            let data = response.data.data
            template = `<span class="rating-overview-box-total">`+Math.round(data.avg,2)+`</span>
                        <span class="rating-overview-box-percent">dari 5</span>
                        <div class="star-rating" data-rating="5">
                          <i class="fa fa-star `+(data.avg>0?`filled`:``)+`"></i>
                          <i class="fa fa-star `+(data.avg>1?`filled`:``)+`"></i>
                          <i class="fa fa-star `+(data.avg>2?`filled`:``)+`"></i>
                          <i class="fa fa-star `+(data.avg>3?`filled`:``)+`"></i>
                          <i class="fa fa-star `+(data.avg>4?`filled`:``)+`"></i>
                        </div>`;
            $(appendTo+'_Avg').html(template);
            template = ``;
            Object.keys(data.percent).forEach(i => {
              template += `<div>
                            <span class="rating-bars-inner">
                              <span class="rating-bars-rating `+(data.percent[i] > 50?'high':(data.percent[i] > 25?'good':(data.percent[i] > 10?'mid':'poor')))+`" data-rating="`+i+`">
                                <span class="rating-bars-rating-inner" style="width: `+data.percent[i]+`%;"></span>
                              </span>
                              <strong title="`+data.percent[i]+`%">`+i+`</strong>
                            </span>
                          </div>`;
            });
            $(appendTo).html(template);
          }else{
            $(appendTo).html(`<b class="text-warning">tidak ada data</b>`);
          }
        }
      }else{
        // swallalert here
        $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C1)</b>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C2)</b>`);
    });
  }

  function getNewsList(page=1,page_size=3,withPagination=false){
    let appendTo = '#newsItemPreview';
    $(appendTo).html(loadingElement);
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
              let imgToDisplay = baseUrl+'/no-image-clean.png'
              let img = new Image();
              img.src = item.img_main+"?_="+(new Date().getTime());
              img.onload = function () {
                imgToDisplay = item.img_main
                $('#news_'+item.id+'_img').attr("src",imgToDisplay)
              }
              // console.log(item.img_author==null,profileToDisplay)
              template +=`<div class="col-lg-4 col-md-6">
                            <div class="grid_blog_box">
                              
                              <div class="gtid_blog_thumb">
                                <a href="blog-detail.html"><img id="news_`+item.id+`_img" src="`+imgToDisplay+`" class="img-fluid" alt="" /></a>
                                <div class="gtid_blog_info"><span>`+postDate+`</span>`+postMonthYear+`</div>
                              </div>								
                              
                              <div class="blog-body">
                                <h4 class="bl-title">
                                  <a href="`+baseUrl+`/berita/`+item.slug+`" class="line-clamp-wrap line-clamp-2">`+item.title+`</a>
                                  <span class="latest_new_post">New</span>
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
            $(appendTo).html(`<b class="text-warning">tidak ada data</b>`);
          }
        // i::data display-------------------------------------------------------------------------------START
      }else{
        // swallalert here
        $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C1)</b>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C2)</b>`);
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
              let imgToDisplay = baseUrl+'/no-image-clean.png'
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
            $(appendTo).html(`<b class="text-warning">tidak ada data</b>`);
          }
        // i::data display-------------------------------------------------------------------------------START
      }else{
        // swallalert here
        $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C1)</b>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C2)</b>`);
    });
  }

  function getOrgList(appendTo=''){
    let payload = {page: 1, page_size: 0};
    axios.post(baseUrl+'/api/get-org-list', payload, apiHeaders)
    .then(function (response) {
      // console.log('[ORG] response..',response);
      let template = '';
      if(response.data.status) {
        if(appendTo){
          if(response.data.data && response.data.data.length > 0) {
            let i = 0;
            let imgToDisplay = baseUrl+'/no-profile.jpg'
            let img = new Image();
            img.src = response.data.data[i].img_main+"?_="+(new Date().getTime());
            img.onload = function () {
              imgToDisplay = response.data.data[i].img_main
              $('#org_'+response.data.data[i].id+'_img').attr("src",imgToDisplay)
            }
            template = `<div class="col-12 col-md-5">
                          <div style="margin-top: 120px">
                              <img src="`+imgToDisplay+`" id="org_`+response.data.data[i].id+`_img" class="rounded-circle d-block m-auto" alt="pic_chief" width="160" height="160">  
                          </div>
                        </div>
                        <div class="col-12 col-md-7">
                          <h2 style="margin-top: 50px">`+response.data.data[i].desc_title+`</h2>
                          <p>`+response.data.data[i].desc_body+`</p>
                          <div class="author font-size-sm mt-4">
                            `+response.data.data[i].name+`<br />
                            <span class="text-muted">`+response.data.data[i].job_title+`</span>
                          </div>
                        </div>`;
            $(appendTo+'_chief').html(template);
            template = '';
            (response.data.data).forEach((item) => {
              img.src = item.img_main+"?_="+(new Date().getTime());
              img.onload = function () {
                imgToDisplay = item.img_main
                $('#org_staff_'+item.id+'_img').attr("src",imgToDisplay)
              }
              template +=`<div class="carousel-item `+(i==0?'active':'')+`">
                            <div class="d-block w-100"> 
                              <div class="single_items">
                                  <div class="grid_agents2">
                                      <div class="sec-heading center" style="margin-top: 50px">
                                          <h3>Anggota</h3>
                                      </div>
                                      <div class="grid_member">
                                        <div class="fr-grid-thumbb">
                                            <a href="#">
                                                <img src="`+imgToDisplay+`" id="org_staff_`+item.id+`_img" class="img-fluid" alt="pic_member">
                                            </a>
                                        </div>
                                        <div class="fr-grid-deatil">
                                            <span>`+item.job_title+`</span>
                                            <h5 class="fr-can-name"><a href="agent-page.html">`+item.name+`</a></h5>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                            </div>
                          </div>`;
              i++;
            });
            $(appendTo).html(template);
          }else{
            $(appendTo+'_chief').html(`<b class="text-warning">tidak ada data</b>`);
          }
        }
      }else{
        // swallalert here
        $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C1)</b>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo+'_chief').html(`<b class="text-warning">Gagal mendapatkan data</b>`);
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
            $(appendTo).html(`<b class="text-warning">tidak ada data</b>`);
          }
        }
      }else{
        // swallalert here
        $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C1)</b>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C2)</b>`);
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

  function addCount(id,act,type){
    axios.get(baseUrl+'/api/'+type+'/post-act/'+id+'/'+act, [], apiHeaders)
    .then(function (response) {
      console.log('[add '+act+' count of '+type+'] response..',response);
      // if(response.data.status) {
       
      // }else{
      //   // swallalert here
      // }
    })
    .catch(function (error) {
      // swallalert here
    });
  }

  function getLPList(page = 1){
    $('#filter_info').html(``);
    $('#legalProductItemPreview').html(loadingElement);
    let appendTo = '';
    let lpt     = $('.lpt:checkbox:checked').map(function() {return this.value;}).get();
    $('[name="_page"]').val(page)
    let payload = {
      _page     : page, 
      _limit    : 10,
      _title    : $('[name="_title"]').val(),
      _status   : $('[name="_status"]').val(),
      _year     : $('[name="_year"]').val(),
      _lpt      : lpt,
      _sort_by  : $('[name="_sort_by"]').val(),
    };
    // console.log('payload', payload); return;
    axios.post(baseUrl+'/api/get-lp-list', payload, apiHeaders)
    .then(function (response) {
      // console.log('[LP] response..',response);
      if(response.data.status) {
        let template = '';
        // i::data statistics----------------------------------------------------------------------------START
          $('#products_count_start').html(response.data.data.products_count_start);
          $('#products_count_end').html(response.data.data.products_count_end);
          $('#products_count_total').html(response.data.data.products_count_total);
          template = `Menampilkan hasil pencarian <u>Produk Hukum</u> yang diundangkan tahun <b>`+(response.data.data.filter._year).replace(';',' sd ')+`</b>`;
          if(response.data.data.filter._lpt_info){
            template += ` bertipe <strong class="theme-cl">(`+lpt.join(', ')+`)</strong>`;
          }
          if(response.data.data.filter._title){
            template += ` dengan judul mengandung kata/kalimat <b><i>"`+response.data.data.filter._title+`"</i></b>`;
          }
          if(response.data.data.filter._status){
            template += ` dan berstatus <b><i>"`+response.data.data.filter._status+`"</i></b>`;
          }
          if(response.data.data.filter._sort_by){
            template += ` diurutkan berdasarkan <u>`+product_sorted_by[response.data.data.filter._sort_by]+`</u>`;
          }
          template += `.`; 
          $('#filter_info').html(template);
        // i::data statistics------------------------------------------------------------------------------END
        // i::data pagination----------------------------------------------------------------------------START
          template = '';
          let max_page = Math.ceil(response.data.data.products_count_total/response.data.data.filter._limit);
          if(response.data.data.filter._page > 1){
            template += `<li><a onclick="getLPList(1)"><i class="fa fa-caret-left" aria-hidden="true"></i></a></li>`;
          }
          if(response.data.data.filter._page-1 >= 1){
            template += `<li><a onclick="getLPList(`+(response.data.data.filter._page-1)+`)">`+(response.data.data.filter._page-1)+`</a></li>`;
          }
          if(response.data.data.filter._page-2 >= 1){
            template += `<li><a onclick="getLPList(`+(response.data.data.filter._page-2)+`)">`+(response.data.data.filter._page-2)+`</a></li>`;
          }
          template += `<li><a onclick="getLPList(`+response.data.data.filter._page+`)" class="active">`+response.data.data.filter._page+`</a></li>`;
          if(response.data.data.filter._page+1 <=  max_page){
            template += `<li><a onclick="getLPList(`+(response.data.data.filter._page+1)+`)">`+(response.data.data.filter._page+1)+`</a></li>`;
          }
          if(response.data.data.filter._page+2 <=  max_page){
            template += `<li><a onclick="getLPList(`+(response.data.data.filter._page+2)+`)">`+(response.data.data.filter._page+2)+`</a></li>`;
          }
          if(response.data.data.filter._page < max_page){
            template += `<li><a onclick="getLPList(`+max_page+`)"><i class="fa fa-caret-right" aria-hidden="true"></i></a></li>`;
          }
          // console.log('template', template);
          $('#plp_pagination').html(template);
        // i::data pagination------------------------------------------------------------------------------END
        // i::data display-------------------------------------------------------------------------------START
          template = '';
          if(response.data.data.products && response.data.data.products.length > 0) {
            // let i = 0;
            (response.data.data.products).forEach((item) => {
              let imgToDisplay = baseUrl+'/no-image-clean.png'
              let img = new Image();
              img.src = item.img_main+"?_="+(new Date().getTime());
              img.onload = function () {
                imgToDisplay = item.img_main
                $('#lp_'+item.id+'_img').attr("src",imgToDisplay)
              }
              template +=`
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="property-listing list_view row align-items-center">
                  <div class="col-xl-2 col-sm-4">
                    <a href="/produk-hukum/`+item.id+`" target="_blank">
                      <img src="`+imgToDisplay+`" id="lp_`+item.id+`_img" class="img-fluid" style="max-height: 150px;" alt="" />
                    </a>
                  </div>
                  <div class="col-xl-10 col-sm-8">
                    <div class="listing-detail-wrapper mt-1">
                      <div class="listing-short-detail-wrap">
                        <div class="_card_list_flex mb-2">
                          <div class="_card_flex_01">
                            <div class="_leads_status">
                              <a href="/produk-hukum/`+item.id+`" target="blank">
                                <span class="active">`+item.legal_product_type+` Nomor `+item.number+` Tahun `+item.year+`</span>
                              </a>
                            </div>
                          </div>
                          <div class="_card_flex_last">
                            <h6 class="listing-card-info-price mb-0">`+item.legal_product_type+`</h6>
                          </div>
                        </div>
                        <div class="_card_list_flex">
                          <div class="_card_flex_01">
                            <h4 class="listing-name verified">
                              <a href="/produk-hukum/`+item.id+`" target="_blank" class="prt-link-detail">`+item.title+`</a>
                            </h4>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="listing-detail-wrapper">
                      <div class="row mx-auto">
                        <span class="col-md-4 col-xs-12 _list_blickes `+(item.status == 'berlaku'?'types':((item.status == 'tdk_berlaku')?'_netork':''))+`">
                          <small><b>
                          `+(item.status == 'tdk_berlaku'?'tidak berlaku':((!item.status)?'<i>?</i>':item.status))+`
                          </b></small>
                        </span>
                        <span class="col-md-3 col-xs-6"><small><i class="fa fa-eye"></i> `+item.view_count+`x dilihat</small></span>
                        <span class="col-md-3 col-xs-6"><small><i class="fa fa-cloud-download"></i> `+item.download_count+`x diunduh</small></span>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>`;
              // i++;
            });
            $('#legalProductItemPreview').html(template);
          }else{
            $('#legalProductItemPreview').html('<h3 class="mt-5">Tidak ada data</h3>');
          }
        // i::data display---------------------------------------------------------------------------------END
      }else{
        // swallalert here
        $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C1)</b>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C2)</b>`);
    });
  }
  
  function getCSList(page = 1){
    $('#filter_info').html(``);
    $('#courtSummonsItemPreview').html(`<tr><td colspan="3">memuat...</td></tr>`);
    let lpt     = $('.lpt:checkbox:checked').map(function() {return this.value;}).get();
    $('[name="_page"]').val(page)
    let payload = {
      _page     : page, 
      _limit    : 10,
      _title    : $('[name="_title"]').val(),
      _year     : $('[name="_year"]').val(),
      _sort_by  : $('[name="_sort_by"]').val(),
    };
    // console.log('payload', payload); return;
    axios.post(baseUrl+'/api/get-cs-list', payload, apiHeaders)
    .then(function (response) {
      // console.log('[CS] response..',response);
      if(response.data.status) {
        let template = '';
        // i::data statistics----------------------------------------------------------------------------START
          $('#products_count_start').html(response.data.data.products_count_start);
          $('#products_count_end').html(response.data.data.products_count_end);
          $('#products_count_total').html(response.data.data.products_count_total);
          template = `Menampilkan hasil pencarian <u>Relaas Pengadilan</u> yang diundangkan tahun <b>`+(response.data.data.filter._year).replace(';',' sd ')+`</b>`;
          if(response.data.data.filter._lpt_info){
            template += ` bertipe (`+lpt.join(', ')+`)`;
          }
          if(response.data.data.filter._title){
            template += ` dengan judul mengandung kata/kalimat <b><i>"`+response.data.data.filter._title+`"</i></b>`;
          }
          if(response.data.data.filter._sort_by){
            template += ` diurutkan berdasarkan <u>`+product_sorted_by[response.data.data.filter._sort_by]+`</u>`;
          }
          template += `.`; 
          $('#filter_info').html(template);
        // i::data statistics------------------------------------------------------------------------------END
        // i::data pagination----------------------------------------------------------------------------START
          template = '';
          let max_page = Math.ceil(response.data.data.products_count_total/response.data.data.filter._limit);
          if(response.data.data.filter._page > 1){
            template += `<li><a onclick="getCSList(1)"><i class="fa fa-caret-left" aria-hidden="true"></i></a></li>`;
          }
          if(response.data.data.filter._page-1 >= 1){
            template += `<li><a onclick="getCSList(`+(response.data.data.filter._page-1)+`)">`+(response.data.data.filter._page-1)+`</a></li>`;
          }
          if(response.data.data.filter._page-2 >= 1){
            template += `<li><a onclick="getCSList(`+(response.data.data.filter._page-2)+`)">`+(response.data.data.filter._page-2)+`</a></li>`;
          }
          template += `<li><a onclick="getCSList(`+response.data.data.filter._page+`)" class="active">`+response.data.data.filter._page+`</a></li>`;
          if(response.data.data.filter._page+1 <=  max_page){
            template += `<li><a onclick="getCSList(`+(response.data.data.filter._page+1)+`)">`+(response.data.data.filter._page+1)+`</a></li>`;
          }
          if(response.data.data.filter._page+2 <=  max_page){
            template += `<li><a onclick="getCSList(`+(response.data.data.filter._page+2)+`)">`+(response.data.data.filter._page+2)+`</a></li>`;
          }
          if(response.data.data.filter._page < max_page){
            template += `<li><a onclick="getCSList(`+max_page+`)"><i class="fa fa-caret-right" aria-hidden="true"></i></a></li>`;
          }
          // console.log('template', template);
          $('#plp_pagination').html(template);
        // i::data pagination------------------------------------------------------------------------------END
        // i::data display-------------------------------------------------------------------------------START
          template = '';
          if(response.data.data.products && response.data.data.products.length > 0) {
            // let i = 0;
            (response.data.data.products).forEach((item) => {
              template +=`
              <tr>
                <td>
                  <div class="_leads_status">
                    <a href="/relaas-pengadilan/`+item.id+`" target="blank">
                      <span class="active">`+item.number+`</span>
                    </a>
                  </div><br>
                  <small>`+item.title+`</small><br>
                  <b>`+item.date_register+`</b>
                </td>
                <td>
                  <small>
                    <br><b>Pemohon</b>: <br>`+item.plaintiff+`<br>
                    <br><b>Termohon</b>: <br>`+item.defendant+`
                  </small>
                </td>
                <td>
                  <small>
                    <i class="fa fa-eye"></i> `+item.view_count+`x<br>
                    <i class="fa fa-cloud-download"></i> `+item.download_count+`x
                  </small>
                </td>
              </tr>`;
              // i++;
            });
            $('#courtSummonsItemPreview').html(template);
          }else{
            $('#courtSummonsItemPreview').html(`<tr><td colspan="3">Tidak ada data</td></tr>`);
          }
        // i::data display---------------------------------------------------------------------------------END
      }else{
        // swallalert here
        $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C1)</b>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $('#courtSummonsItemPreview').html(`<tr><td colspan="3"><b class="text-warning">Gagal mendapatkan data</b></td></tr>`);
    });
  }
  
  function getCCHList(page = 1){
    $('#filter_info').html(``);
    $('#courtCaseHandlingItemPreview').html(`<tr><td colspan="4">memuat...</td></tr>`);
    let lpt     = $('.lpt:checkbox:checked').map(function() {return this.value;}).get();
    $('[name="_page"]').val(page)
    let payload = {
      _page                 : page, 
      _limit                : 10,
      _title                : $('[name="_title"]').val(),
      _year                 : $('[name="_year"]').val(),
      _case_status          : $('[name="_case_status"]').val(),
      _case_type            : $('[name="_case_type"]').val(),
      _case_classification  : $('[name="_case_classification"]').val(),
      _sort_by              : $('[name="_sort_by"]').val(),
    };
    // console.log('payload', payload); return;
    axios.post(baseUrl+'/api/get-cch-list', payload, apiHeaders)
    .then(function (response) {
      // console.log('[CCH] response..',response);
      if(response.data.status) {
        let template = '';
        // i::data statistics----------------------------------------------------------------------------START
          $('#products_count_start').html(response.data.data.products_count_start);
          $('#products_count_end').html(response.data.data.products_count_end);
          $('#products_count_total').html(response.data.data.products_count_total);
          template = `Menampilkan hasil pencarian <u>Penangann Perkara</u> yang diundangkan tahun <b>`+(response.data.data.filter._year).replace(';',' sd ')+`</b>`;
          if(response.data.data.filter._lpt_info){
            template += ` bertipe (`+lpt.join(', ')+`)`;
          }
          if(response.data.data.filter._title){
            template += ` dengan judul mengandung kata/kalimat <b><i>"`+response.data.data.filter._title+`"</i></b>`;
          }
          if(response.data.data.filter._case_status){
            template += ` status perkara <b><i>"`+response.data.data.filter._case_status+`"</i></b>`;
          }
          if(response.data.data.filter._case_type){
            template += ` tipe perkara <b><i>"`+response.data.data.filter._case_type+`"</i></b>`;
          }
          if(response.data.data.filter._case_classification){
            template += ` bertipe perkara <b><i>"`+response.data.data.filter._case_classification+`"</i></b>`;
          }
          if(response.data.data.filter._sort_by){
            template += ` diurutkan berdasarkan <u>`+product_sorted_by[response.data.data.filter._sort_by]+`</u>`;
          }
          template += `.`; 
          $('#filter_info').html(template);
        // i::data statistics------------------------------------------------------------------------------END
        // i::data pagination----------------------------------------------------------------------------START
          template = '';
          let max_page = Math.ceil(response.data.data.products_count_total/response.data.data.filter._limit);
          if(response.data.data.filter._page > 1){
            template += `<li><a onclick="getCCHList(1)"><i class="fa fa-caret-left" aria-hidden="true"></i></a></li>`;
          }
          if(response.data.data.filter._page-1 >= 1){
            template += `<li><a onclick="getCCHList(`+(response.data.data.filter._page-1)+`)">`+(response.data.data.filter._page-1)+`</a></li>`;
          }
          if(response.data.data.filter._page-2 >= 1){
            template += `<li><a onclick="getCCHList(`+(response.data.data.filter._page-2)+`)">`+(response.data.data.filter._page-2)+`</a></li>`;
          }
          template += `<li><a onclick="getCCHList(`+response.data.data.filter._page+`)" class="active">`+response.data.data.filter._page+`</a></li>`;
          if(response.data.data.filter._page+1 <=  max_page){
            template += `<li><a onclick="getCCHList(`+(response.data.data.filter._page+1)+`)">`+(response.data.data.filter._page+1)+`</a></li>`;
          }
          if(response.data.data.filter._page+2 <=  max_page){
            template += `<li><a onclick="getCCHList(`+(response.data.data.filter._page+2)+`)">`+(response.data.data.filter._page+2)+`</a></li>`;
          }
          if(response.data.data.filter._page < max_page){
            template += `<li><a onclick="getCCHList(`+max_page+`)"><i class="fa fa-caret-right" aria-hidden="true"></i></a></li>`;
          }
          // console.log('template', template);
          $('#plp_pagination').html(template);
        // i::data pagination------------------------------------------------------------------------------END
        // i::data display-------------------------------------------------------------------------------START
          template = '';
          if(response.data.data.products && response.data.data.products.length > 0) {
            // let i = 0;
            (response.data.data.products).forEach((item) => {
              template += `
              <tr>
                <td>
                  <div class="_leads_status">
                    <a href="/penanganan-perkara/`+item.id+`" target="blank">
                      <span class="active">`+item.number+`</span>
                    </a>
                  </div><br>
                  `+item.case_classification_attr.label+`<br>
                  <b>`+item.date_register+`</b>
                </td>
                <td>
                  <small>
                    <br><b>Pemohon</b>: <br>`+item.plaintiff+`<br>
                    <br><b>Termohon</b>: <br>`+item.defendant+`
                  </small>
                </td>
                <td>
                  <small>`+item.case_status_attr.label+`</small>
                </td>
                <td>
                  <small>
                    <i class="fa fa-eye"></i> `+item.view_count+`x<br>
                    <i class="fa fa-cloud-download"></i> `+item.download_count+`x
                  </small>
                </td>
              </tr>`;
              // i++;
            });
            $('#courtCaseHandlingItemPreview').html(template);
          }else{
            $('#courtCaseHandlingItemPreview').html(`<tr><td colspan="4">Tidak ada data</td></tr>`);
          }
        // i::data display---------------------------------------------------------------------------------END
      }else{
        // swallalert here
        $(appendTo).html(`<b class="text-warning">Gagal mendapatkan data (C1)</b>`);
      }
    })
    .catch(function (error) {
      // swallalert here
      $('#courtCaseHandlingItemPreview').html(`<tr><td colspan="4"><b class="text-warning">Gagal mendapatkan data</b></td></tr>`);
    });
  }