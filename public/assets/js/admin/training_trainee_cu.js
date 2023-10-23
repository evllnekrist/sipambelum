console.log('training trainee CU')

$(function(){
  // $("#input-file").fileinput();
  const subdistrict_ids = ($("[name='subdistrict_ids']").val()).split(",");
  // console.log('subdistrict_ids',subdistrict_ids)

  function searchTrainee_closeResult(){
    $('.search_trainee_input:checked').each(function() {
      $(this).prop('checked',false)
    });
    $("#advance-search").hide();
  }

  $("#btn-trainees-add-cancel").click(function(e){
    searchTrainee_closeResult();
  });

  $("#btn-trainees-add").click(function(e){
    // let search_trainee = [];
    let search_trainee_data = {};
    $('.search_trainee_input:checked').each(function() {
      // search_trainee.push($(this).val());
      search_trainee_data[$(this).val()] = $(this).data('complete');
    });
    searchTrainee_closeResult();
    // console.log('search trainee',search_trainee_data);
    let template = ``; let item = {}; let sd = ``;
    for (var key in search_trainee_data) {
      item  = search_trainee_data[key];
      sd    = (item['subdistrict_of_residence']).toString()
      // console.log('item',item)
      // console.log('subdistrict_ids',subdistrict_ids)
      // console.log('sd',sd)
      // console.log('==',subdistrict_ids.includes(sd))
      if(subdistrict_ids.includes(sd)){      
        $("#subdistrict-"+sd+"-wrap").show();
        template = `
        <tr>
          <td>
              <b>`+item.name+`</b><br>
              <span>`+item.nik+`</span><br>
              <span>`+item.aktif+`</span>
          </td>
          <td>
              <div class="_leads_status"><span class="active">`+item.level+`</span></div>
              <span>Update terakhir ...</span>
          </td>
          <td>
              <div class="prt_leads"><span>27 till now</span></div>
              <div class="prt_leads_list">
                  <ul>
                      <li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
                      <li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
                      <li><a href="#" class="_leads_name style-1">K</a></li>
                      <li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
                      <li><a href="#" class="leades_more">10+</a></li>
                  </ul>
              </div>
          </td>
          <td>
              <div class="prt_leads"><span>27 till now</span></div>
              <div class="prt_leads_list">
                  <ul>
                      <li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
                      <li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
                      <li><a href="#" class="_leads_name style-1">K</a></li>
                      <li><a href="#"><img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt="" /></a></li>
                      <li><a href="#" class="leades_more">10+</a></li>
                  </ul>
              </div>
          </td>
          <td>
              <div class="_leads_action">
                  <a href="#" class="delete"><i class="ti-close"></i></a>
                  <a href="#"><i class="ti-check"></i></a>
              </div>
          </td>
        </tr>`;
        $("#subdistrict-"+sd+"-tbody").append(template);
      }else{
        Swal.fire({
          position: 'top-end',
          icon: 'warning',
          title: "Hmm..",
          html: '<small>'+item.name+' tidak terdaftar dalam kecamatan manapun. Tidak bisa menambahkan ke list.</small>',
          showConfirmButton: true,
        });
      }
    };
  });

  $("#btn-trainees-search").click(function(e){
    let appendTo = '#advance-search';
    $(appendTo+'-info').show();
    $(appendTo+'-loading').show();
    $(appendTo).hide();
    // return
    let payload = {};
    if($('#subdistrict').val()){
      payload['_subdistrict'] = $('#subdistrict').val();
    }
    if($('#level').val()){
      payload['_level'] = $('#level').val();
    }
    if($('#search').val()){
      payload['_search'] = $('#search').val();
    }
    axios.post(baseUrl+'/api/get-trainee-list-adv', payload, apiHeaders)
    .then(function (response) {
      console.log('[TRAINING TRAINEE] response..',response);
      let template = '';
      if(response.data.status) {
        template = ''
        if(response.data.data.products && response.data.data.products.length > 0) {
          let i = 0;
          (response.data.data.products).forEach((item) => {
            i++;
            template +=`<li>
                            <input id="search_trainee_`+i+`" class="form-check-input search_trainee_input" value="`+item.id+`" data-complete='`+JSON.stringify(item)+`' type="checkbox">
                            <label for="search_trainee_`+i+`" class="form-check-label">`+item.name+` (<b class="text-level-`+item.level+`">`+item.level+`</b>)
                            <table class="text-smaller">
                              <tr>
                                <td>NIK</td>
                                <td>`+item.nik+`</td>
                              </tr>
                              <tr>
                                <td>Kecamatan</td>
                                <td>`+(item.subdistrict?item.subdistrict.name:` - `)+`</td>
                              </tr>
                            </table>
                            </label>
                        </li>`;
          });
          $(appendTo+'-trainee-list').html(template);
          $(appendTo+'-info').hide();
          $(appendTo).show();
        }else{
          $(appendTo+'-info-content').html(`<center><b class="text-warning">tidak ada data</b></center>`);
        }
      }else{
        $(appendTo+'-info-content').html(`<center><b class="text-warning">tidak ada data</b></center>`);
      }
      $(appendTo+'-loading').hide();
    })
    .catch(function (error) {
      $(appendTo+'-loading').hide();
      $(appendTo+'-info-content').html(`<center><b class="text-warning">Gagal mendapatkan data (C2)</b><br><small>`+error.message+`</small>`);
    });
  });

  $("#btn-submit-edit").click(function(e){
    const form = document.getElementById('form');
    form.reportValidity()
    if (!form.checkValidity()) {
    } else {
      $('#loading').show();
      $('#form').hide();
      const formData = new FormData(form);
      // for (const [key, value] of formData) {
      //   console.log('»', key, value)
      // }
      axios.post(baseUrl+'/api/training/post-edit', formData, apiHeaders)
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
          // window.location = baseUrl+'/admin-katkab/training';
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
    }
  });

});
