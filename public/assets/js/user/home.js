console.log('HOME 23-05-17 01')

$(function(){
   // enable for dynamic banner ------ start
  // getBannerList('#bannerItemSlider')
   // enable for dynamic banner ------ else
  $('.home-slider').slick({
    centerMode:false,
    slidesToShow:1,
    responsive: [
    {
      breakpoint: 768,
      settings: {
      arrows:true,
      slidesToShow:1
      }
    },
    {
      breakpoint: 480,
      settings: {
      arrows: false,
      slidesToShow:1
      }
    }
    ]
  });
  inlineCSS();
  // enable for dynamic banner ------ end
  getStatistics_LegalProduct_ByType('#LegalProductStatistic')
  getNewsList(1,3)
  getOrgList('#orgItemCarousel')
  getSelectionList('#servicePreview','JDIH_SERVICE')
});
