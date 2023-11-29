console.log('TRAINING IDX');

function doDelete(id, name) {
  if (confirm("Apakah Anda yakin menghapus trainee dengan ID '" + id + "' dan nama '" + name + "'? Aksi ini tidak dapat dibatalkan.")) {
    axios.post(baseUrl+'/api/trainee/post-delete/' + id, {}, apiHeaders)
    .then(function (response) {
      console.log('response..', response);
      if (response.status == 200 && response.data.status) {
        Swal.fire({
          icon: 'success',
          width: 600,
          title: "Berhasil",
          confirmButtonText: 'Ya, terima kasih',
        });
        window.location = baseUrl+'/admin-katkab/trainee';
      } else {
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
  } else {
    Swal.fire({
      icon: 'info',
      width: 600,
      html: 'Batal dihapus',
      confirmButtonText: 'Ya',
    });
  }
}
function getData() {
  $('#page-loading').html(loadingElement);
  let url = baseUrl+'/api/get-trainee-list';
  let page = 1, pageSize = 10;
  let payload = { page: page, page_size: pageSize };
  console.log('tryin to retrieve data....', url);
  axios.post(url, payload, apiHeaders)
  .then(function (response) {
    console.log('[DATA] response..', response.data.data);
    if (response.data.status) {
      var table = $('#data-list').DataTable({
        language: {
          "paginate": {
            "previous": "<<",
            "next": ">>"
          }
        },
        dom: 'Bfrtip',
        data: response.data.data,
        columns: [
          { data: 'id' },
          { data: 'nik' },
          { data: null, render: function ( data, type, row ) {
            return '<a href="'+baseUrl+'/admin-katkab/trainee/edit/'+data.id+'" target="_blank" class="text-blue-b">'+data.name+'</a>';
          } 
        },
          {
            data: 'sex', render: function (data, type, row) {
                return data === 'm' ? 'Laki-Laki' : 'Perempuan';
            }
        },
          { data: 'religion' },
          { data: 'place_of_birth' },
          { data: 'date_of_birth' },
          { data: 'latest_edu' },
          { data: 'phone' },
          { data: 'email' },
          {
            data: 'subdistrict_of_residence', render: function (data, type, row) {
              return row.subdistrict ? row.subdistrict.name : ''; // Mengambil nama kecamatan dari objek subdistrict jika ada
            }
          },
          {
            data: null, render: function (data, type, row) {
              return '<a onclick="doDelete(' + data.id + ',`' + data.name + '`)" class="text-danger"><i class="nav-icon fas fa-trash"></i></a>';
            }
          },
        ],
        
      });

      table.on('order.dt search.dt', function () {
        var i = 1;
        table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
          this.data(i++);
        }).draw();
      });
    } else {
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
getData();


