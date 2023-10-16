console.log('BUSINESS IDX');

function doDelete(id, name) {
  if (confirm("Apakah Anda yakin menghapus bisnis dengan ID '" + id + "' dan nama '" + name + "'? Aksi ini tidak dapat dibatalkan.")) {
    axios.post(baseUrl+'/api/business/post-delete/' + id, {}, apiHeaders)
    .then(function (response) {
      console.log('response..', response);
      if (response.status == 200 && response.data.status) {
        Swal.fire({
          icon: 'success',
          width: 600,
          title: "Berhasil",
          confirmButtonText: 'Ya, terima kasih',
        });
        window.location = baseUrl+'/admin-katkab/business';
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
function showDetail(id) {
    // Mengambil data bisnis berdasarkan ID menggunakan AJAX
    $.ajax({
      url: baseUrl + '/api/business/' + id, // Ganti dengan URL endpoint yang sesuai
      method: 'GET',
      success: function(response) {
        // Menampilkan data bisnis dalam modal
        $('#detailModalLabel').text('Detail Bisnis : ' + response.name);
        $('#nib').text(response.nib);
        $('#name').text(response.name);
        $('#phone').text(response.phone);
        $('#email').text(response.email);
        $('#address').text(response.address);
        $('#subdistrict').text(response.subdistrict);
        $('#date_of_establishment').text(response.date_of_establishment);
        $('#initial_business_capital').text(response.initial_business_capital);
        $('#revenue').text(response.revenue);
        $('#digitalization').text(response.digitalization);
        $('#employees_count').text(response.employees_count);
        $('#development_problems').text(response.development_problems);
        $('#training_needs').text(response.training_needs);
        $('#is_sales_transaction').text(response.is_sales_transaction === 1 ? 'Ya' : 'Tidak');
        $('#is_access_to_funding').text(response.is_access_to_funding === 1 ? 'Ya' : 'Tidak');
        $('#is_financial_report').text(response.is_financial_report === 1 ? 'Ya' : 'Tidak');
        $('#is_business_account').text(response.is_business_account === 1 ? 'Ya' : 'Tidak');
        // Tambahkan kolom lainnya sesuai kebutuhan
  
        // Menampilkan modal
        $('#detailModal').modal('show');
      },
      error: function(error) {
        // Menangani kesalahan saat mengambil data bisnis
        console.error('Error:', error);
      }
    });
  }
  
  
  
function getData() {
  $('#page-loading').html(loadingElement);
  let url = baseUrl+'/api/get-business-list';
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
            { data: 'nib' },
            { data: 'name' },
            { data: 'phone' },
            { data: 'email' },
            { data: 'address' },
            {
              data: 'subdistrict', render: function (data, type, row) {
                return row.subdistrict ? row.subdistrict.name : ''; // Mengambil nama kecamatan dari objek subdistrict jika ada
              }
            },
            {
              data: null,
              render: function (data, type, row) {
                return '<a onclick="showDetail(' + data.id + ')" class="text-primary"><i class="nav-icon fas fa-eye"></i> Detail</a>' +
                  ' <a onclick="doDelete(' + data.id + ',`' + data.name + '`)" class="text-danger"><i class="nav-icon fas fa-trash"></i></a>' +
                  ' <a href="' + baseUrl + '/admin-katkab/business/edit/' + data.id + '" class="text-primary"><i class="nav-icon fas fa-edit"></i></a>';
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
