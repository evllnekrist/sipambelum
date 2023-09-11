// console.log('LEGAL PRODUCT 18-06-31 01')

function resetFilterLP(){
  $('[name="_title"]').val('');
  $('[name="_status"]').val(''),
  $('[name="_year"]').val('1945;'+new Date().getFullYear());
  $('.lpt:checkbox').prop('checked', true);
  $('[name="_sort_by"]').val('latest');
  getLPList(); // auto page 1
}

$(function(){
  getLPList();
});
