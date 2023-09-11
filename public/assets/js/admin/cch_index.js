console.log('LP IDX V-23-06-28 01')
console.log('baseUrl ',baseUrl)

function doDelete(id,name){
  if(confirm("Apakah Anda yakin menghapus dokumen '"+name+"'? Aksi ini tidak dapat dibatalkan.")){
    axios.post(baseUrl+'/api/cch/post-delete/'+id, {}, apiHeaders)
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
        window.location = baseUrl+'/admin-jdih-katkab/cch';
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
    let url = baseUrl+'/api/get-cch-listfull'
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
              { data: 'number' },
              { data: null, render: function ( data, type, row ) { 
                  return '<a href="'+baseUrl+'/admin-jdih-katkab/cch/edit/'+data.id+'" target="_blank">'+data.title+'</a>';
                } 
              },
              { data: 'date_register' },
              { data: 'plaintiff' },
              { data: 'defendant' },
              { data: null, render: function ( data, type, row ) { 
                  return data.case_status?data.case_status_attr['label']:(data.case_type?'<i>nilai tidak ada di master</i>':'-');
                } 
              },
              { data: null, render: function ( data, type, row ) { 
                  return data.case_type_attr?data.case_type_attr['label']:(data.case_type?'<i>nilai tidak ada di master</i>':'-');
                } 
              },
              { data: null, render: function ( data, type, row ) { 
                  return data.case_classification?data.case_classification_attr['label']:(data.case_type?'<i>nilai tidak ada di master</i>':'-');
                } 
              },
              { data: 'process_time' },
              { data: null, render: function ( data, type, row ) { 
                  return data.tags?data.tags.replace(/,/g, ", "):'';
                } 
              },
              { data: null, render: function ( data, type, row ) { 
                  return '<a onclick="doDelete('+data.id+',`'+data.title+'`)" class="text-danger"><i class="nav-icon fas fa-trash"></i></a>';
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