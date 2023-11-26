console.log('HOME 23-09-24 01')

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
  getStatistics_traineeOfTraining()
  getNewsList(1,4)
  getTrainingList()
  getSelectionList('#collaboratorPreview','OFFICIAL')
});
