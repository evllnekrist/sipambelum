console.log('training IDX')

function doDelete(id,name){
  if(confirm("Apakah Anda yakin menghapus training '"+name+"'? Aksi ini tidak dapat dibatalkan.")){
    axios.post(baseUrl+'/api/training/post-delete/'+id, {}, apiHeaders)
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
        window.location = baseUrl+'/admin-katkab/training';
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

function getData(){
  $('#page-loading').html(loadingElement);
  let url = baseUrl+'/api/get-training-listfull'
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
          scrollX: true,
          dom: 'Bfrtip',
          data: response.data.data,
          columns: [ 
            { data: 'id'},
            { data: null, render: function ( data, type, row ) {
                return '<img src="'+data.img_main+'" alt="'+data.title+'" height="70px">';
              }, className: "text-center" 
            },
            { data: null, render: function ( data, type, row ) {
                return '<a href="'+baseUrl+'/admin-katkab/training/edit/'+data.id+'" target="_blank" class="text-blue-b">'+data.name+'</a>';
              } 
            },
            { data: 'level' },
            { data: 'trainee_limit' },
            { data: null, render: function ( data, type, row ) {
                return (data.is_online?'<i class="fas fa-wifi text-blue" title="Online"></i>':
                '<i class="fas fa-map-marker-alt text-danger" title="Offline"></i>')+
                '<span class="span-icon-content">'+data.address+'</span>';
              }, className: "w300" 
            },
            { data: 'event_start' },
            { data: 'event_end' },
            { data: 'contact_phone' },
            { data: 'contact_email' },
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