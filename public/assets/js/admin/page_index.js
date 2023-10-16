console.log('PAGE IDX')

function doDelete(id,name){
  if(confirm("Apakah Anda yakin menghapus laman '"+name+"'? Aksi ini tidak dapat dibatalkan.")){
    axios.post(baseUrl+'/api/page/post-delete/'+id, {}, apiHeaders)
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
        window.location = baseUrl+'/admin-katkab/page';
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

let noDeleteItems = ['hubungi-kami','sk-tim','sop','struktur-org','visi-misi'];
function getData(){
  $('#page-loading').html(loadingElement);
  let url = baseUrl+'/api/get-page-list'
  let page = 1, pageSize = 10
  let payload = {page: page, page_size: pageSize}
  console.log('tryin to retrieve data....',url)
  axios.post(url, payload, apiHeaders)
  .then(function (response) {
    //console.log('[DATA] response..',response.data.data);
    if(response.data.status) {
        var table = $('#data-list').DataTable({ // https://datatables.net/manual/data/
          language: {
            "paginate": {
              "previous": "<<",
              "next": ">>"
            }
          },
          dom: 'Bfrtip',
          data: response.data.data,
          columns: [ 
            { data: 'id'},
            { data: null, render: function ( data, type, row ) { // https://editor.datatables.net/examples/api/triggerButton.html
                return '<a href="'+baseUrl+'/admin-katkab/page/edit/'+data.id+'" target="_blank" class="text-blue-b">'+data.title+'</a>';
              } 
            },
            { data: 'slug' },
            { data: null, render: function ( data, type, row ) { 
                if(!noDeleteItems.includes(data.slug)){
                  return '<a onclick="doDelete('+data.id+',`'+data.name+'`)" class="text-danger"><i class="nav-icon fas fa-trash"></i></a>';
                }else{
                  return '<small title="tidak boleh dihapus"><i>laman wajib</i></small>'
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