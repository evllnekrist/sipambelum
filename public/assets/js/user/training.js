// console.log('TRAINING 18-10-23 01')

function resetFilter(){
    $('[name="_title"]').val('');
    // $('[name="_status"]').val(''),
    $('[name="_year"]').val('1945;'+new Date().getFullYear());
    $('.level:checkbox').prop('checked', true);
    $('[name="_sort_by"]').val('latest');
    getTrainingList(1,true); // auto page 1
}

$(function(){
    console.log('get Listing');
    getTrainingList(1,true);
});
  