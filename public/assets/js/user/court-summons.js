// console.log('COURT SUMMONS 21-06-31 01')

function resetFilterCS(){
  $('[name="_title"]').val('');
  $('[name="_year"]').val('1945;'+new Date().getFullYear());
  $('[name="_sort_by"]').val('latest');
  getCSList(); // auto page 1
}

$(function(){
  getCSList();
});
