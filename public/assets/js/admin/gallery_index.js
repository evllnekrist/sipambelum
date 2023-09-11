console.log('GALLERY IDX V-23-06-28 01')
console.log('baseUrl ',baseUrl)

function doDelete(id,name){
  if(confirm("Apakah Anda yakin menghapus '"+name+"'? Aksi ini tidak dapat dibatalkan.")){
    axios.post(baseUrl+'/api/gallery/post-delete/'+id, {}, apiHeaders)
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
        window.location = baseUrl+'/admin-jdih-katkab/gallery';
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
  function getData(){
    $('#page-loading').html(loadingElement);
    let url = baseUrl+'/api/get-gallery-listfull'
    let page = 1, pageSize = 10
    let payload = {page: page, page_size: pageSize}
    console.log('tryin to retrieve data....',url)
    axios.post(url, payload, apiHeaders)
    .then(function (response) {
      //console.log('[DATA] response..',response.data.data);
      if(response.data.status) {
          var table = $('#data-list').DataTable({ // https://datatables.net/manual/data/
            dom: 'Bfrtip',
            data: response.data.data,
            columns: [ 
              { data: 'id'},
              { data: null, render: function ( data, type, row ) { // https://editor.datatables.net/examples/api/triggerButton.html
                  if(data.media_type=='img'){
                    return '<img src="'+data.media_main+'" alt="'+data.title+'" height="70px">';
                  }else{
                    return '<a href="'+data.media_main+'" target="_blank"><i>lihat '+data.media_type+'</i></a>';
                  }
                },className: "text-center" 
              },
              { data: null, render: function ( data, type, row ) { // https://editor.datatables.net/examples/api/triggerButton.html
                  return '<a href="'+baseUrl+'/admin-jdih-katkab/gallery/edit/'+data.id+'" target="_blank">'+data.title+'</a>';
                }
              },
              { data: 'tags' },
              { data: null, render: function ( data, type, row ) { 
                  return '<a onclick="doDelete('+data.id+',`'+data.name+'`)" class="text-danger"><i class="nav-icon fas fa-trash"></i></a>';
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