console.log('REGISTER-INDEX IDX V-23-05-22 01')
console.log('baseUrl ',baseUrl)

function doDelete(id,name){
  if(confirm("Apakah Anda yakin menghapus user '"+name+"'? Aksi ini tidak dapat dibatalkan.")){
    axios.post(baseUrl+'/api/user/post-delete/'+id, {}, apiHeaders)
    .then(function (response) {
      console.log('response..',response);
      if(response.status == 200 && response.data.status) {
        Swal.fire({
          icon: 'success',
          width: 600,
          title: "Berhasil",
          // html: "...",
          confirmButtonText: 'Ya, terima kasih',
        });
        window.location = baseUrl+'/admin-jdih-katkab/user';
      }else{
        Swal.fire({
          icon: 'warning',
          width: 600,
          title: "Gagal",
          html: response.data.message,
          confirmButtonText: 'Ya',
        });
      }
      $('#loading').hide();
      $('#form').show();
    })
    .catch(function (error) {
      Swal.fire({
        icon: 'error',
        width: 600,
        title: "Error",
        html: error,
        confirmButtonText: 'Ya',
      });
      $('#loading').hide();
      $('#form').show();
    });
  }else{
    Swal.fire({
      icon: 'info',
      width: 600,
      html: 'Batal dihapus',
      confirmButtonText: 'Ya',
    });
  }
}

$(function () {
  // $("#example1").DataTable({
  //   "responsive": true, "lengthChange": false, "autoWidth": false,
  //   "buttons": ["copy", "excel", "pdf", "print", "colvis"]
  // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  // $('#example2').DataTable({
  //   "paging": true,
  //   "lengthChange": false,
  //   "searching": false,
  //   "ordering": true,
  //   "info": true,
  //   "autoWidth": false,
  //   "responsive": true,
  // });

  let noDeleteItems = ['ev.attoff@gmail.com','superuser@mail.com'];
  function getData(){
    let url = baseUrl+'/api/get-user-list'
    let page = 1, pageSize = 10
    let payload = {page: page, page_size: pageSize}
    console.log('tryin to retrieve data....',url)
    axios.post(url, payload, apiHeaders)
    .then(function (response) {
      //console.log('[DATA] response..',response.data.data);
      if(response.data.status) {
          $('#data-list').DataTable({ // https://datatables.net/manual/data/
            dom: 'Bfrtip',
            data: response.data.data,
            columns: [ 
              { data: null, render: function ( data, type, row ) { // https://editor.datatables.net/examples/api/triggerButton.html
                  return '<img src="/assets/img/profile/'+data.img_profile_id+'.png" alt="'+data.name+'`s profile picture" height="70px">';
                },className: "text-center" 
              },
              { data: null, render: function ( data, type, row ) { // https://editor.datatables.net/examples/api/triggerButton.html
                  return '<a href="'+baseUrl+'/admin-jdih-katkab/profile/'+data.id+'" target="_blank">'+data.name+'</a>';
                },className: "align-middle" 
              },
              { data: 'email',className: "align-middle" },
              { data: 'role',className: "align-middle" },
              { data: null, render: function ( data, type, row ) { 
                  if(!noDeleteItems.includes(data.email)){
                    return '<a onclick="doDelete('+data.id+',`'+data.name+'`)" class="text-danger"><i class="nav-icon fas fa-trash"></i></a>';
                  }else{
                    return '<small><i>no delete</i></small>'
                  }
                },className: "align-middle" 
              },
            ],
          });
      }else{
        Swal.fire({
          icon: 'warning',
          width: 600,
          title: "Gagal",
          html: response.data.message,
          confirmButtonText: 'Ya',
        });
      }
    })
    .catch(function (error) {
      Swal.fire({
        icon: 'error',
        width: 600,
        title: "Error",
        html: error,
        confirmButtonText: 'Ya',
      });
      console.log(error);
    });
  }
  getData()
});