console.log('ORG IDX V-23-06-28 01')
console.log('baseUrl ',baseUrl)

function doDelete(id,name){
  if(confirm("Apakah Anda yakin menghapus '"+name+"'? Aksi ini tidak dapat dibatalkan.")){
    axios.post(baseUrl+'/api/org/post-delete/'+id, {}, apiHeaders)
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
        window.location = baseUrl+'/admin-jdih-katkab/org';
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
  let noDeleteItems = [1];
  function getData(){
    $('#page-loading').html(loadingElement);
    let url = baseUrl+'/api/get-org-list'
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
                  return '<img src="'+data.img_main+'" alt="'+data.name+'`s profile picture" height="70px">';
                },className: "text-center" 
              },
              { data: null, render: function ( data, type, row ) { // https://editor.datatables.net/examples/api/triggerButton.html
                  return '<a href="'+baseUrl+'/admin-jdih-katkab/org/edit/'+data.id+'" target="_blank">'+data.name+'</a>';
                }
              },
              { data: 'job_title' },
              { data: null, render: function ( data, type, row ) { // https://editor.datatables.net/examples/api/triggerButton.html
                  return data.superior_attr?data.superior_attr['job_title']+`<br><small>(`+data.superior_attr['name']+`)</small>`:'-';
                }
              },
              { data: null, render: function ( data, type, row ) { 
                  if(!noDeleteItems.includes(data.id)){
                    return '<a onclick="doDelete('+data.id+',`'+data.name+'`)" class="text-danger"><i class="nav-icon fas fa-trash"></i></a>';
                  }else{
                    return '<small><i>superior 1,<br>tidak boleh dihapus,<br>hanya dapat diganti</i></small>'
                  }
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