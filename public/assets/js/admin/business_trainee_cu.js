console.log('business trainee CU 231030')
// console.log('datetime',(new Date).toLocaleString('id-ID'))

const subdistrict_ids     = ($("[name='subdistrict_ids']").val()).split(",");
let trainees_new          = [];
let trainees_to_delete    = [];
let trainees_approved_not = [];
let trainees_approved     = $("[name='trainees_approved']").val()?($("[name='trainees_approved']").val()).split(","):[];

function searchTrainee_closeResult(){
  $('.search-trainee-input:checked').each(function() {
    
    $(this).prop('checked',false)
  });
  $("#advance-search").hide();
}

function qualifiedToMark(id){
  // console.log('get element of trainee-'+id+'-approved',$("#trainee-"+id+"-approved"))
  if(!document.getElementById("trainee-"+id+"-approved")){
    Swal.fire({
      position: 'top-end',
      html: '<b>Penilaian tidak bisa dilakukan</b><br><small>Peserta belum/tidak disetujui Admin</small>',
      showConfirmButton: false,
    });
    return false
  }
  return true
}

function valuateDisplay(valueateSD = true) {
  if (valueateSD) {
    subdistrict_ids.forEach(id => {
      if (!document.getElementById("subdistrict-" + id + "-tbody").childElementCount) {
        $("#subdistrict-" + id + "-wrap").hide();
      }
    });
  }
  let total_trainee = $(".trainee-wrap").length;
  $("#summary-count-trainees-displayed").html(total_trainee);
  $("#summary-count-trainees-approved").html(trainees_approved.length);
  $("#summary-count-trainees-approved-not").html(total_trainee - trainees_approved.length);
  console.log('%c\n______summaries::start', 'background: #222; color: #bada55');
  console.log('trainees_approved : ', trainees_approved);
  console.log('trainees_approved_not : ', trainees_approved_not);
  console.log('%c______summaries::end\n', 'background: #222; color: #bada55');
}


function uncheck_all(){
  $("*[class^='check-all']").prop('checked',false)
}

$(function(){

  valuateDisplay(false)

  $("#btn-trainees-add-cancel").click(function(e){
    searchTrainee_closeResult();
  });

  $("#btn-trainees-add").click(function(e) {
    let search_trainee_data = {};
    $('.search-trainee-input:checked').each(function() {
      trainees_new.push($(this).val());
      search_trainee_data[$(this).val()] = $(this).data('complete');
    });
    searchTrainee_closeResult();

    let template = '';
    for (var key in search_trainee_data) {
      let item = search_trainee_data[key];
      let sd = (item['subdistrict_of_residence']).toString();

      if (subdistrict_ids.includes(sd)) {
        $("#subdistrict-" + sd + "-wrap").show();
        if (trainees_to_delete.includes(item.id)) {
          trainees_to_delete.splice(trainees_to_delete.indexOf(item.id), 1);
        }

        if (!document.getElementById("subdistrict-" + item.id + "-trainee")) {
          let existingJobTitle = item.job_title || '';
          template = `
          <tr class="trainee-wrap" id="subdistrict-${item.id}-trainee">
            <td>
              <input type="checkbox" class="check-all-group-${sd} checkbox-trainee" data-id="${item.id}">
            </td>
            <td class="row">
              <div class="col-3" id="trainee-${item.id}-approved-wrap">
              </div>
              <div class="col-9">
                <b>${item.name}</b><br>
                <span>${item.nik}</span><br>
              </div>
            </td>
            <td>
              <div class="_leads_action" data-id="${item.id}">
                <input type="text" id="job_title_input_${item.id}" class="form-control" placeholder="Ketikan Jabatan" value="${existingJobTitle}">
              </div>
            </td>
          </tr>`;
        }
        if (!document.getElementById("subdistrict-" + item.id + "-trainee")) {
          $("#subdistrict-" + sd + "-tbody").append(template);
      } else {
          // Jika sudah ada, perbarui nilai job_title
          $(`#job_title_input_${item.id}`).val(existingJobTitle);
      }
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
    axios.post(baseUrl+'/api/get-trainee-list-tb', payload, apiHeaders)
    .then(function (response) {
      console.log('[business TRAINEE] response..',response);
      let template = '';
      if(response.data.status) {
        template = ''
        if(response.data.data.products && response.data.data.products.length > 0) {
          let i = 0;
          (response.data.data.products).forEach((item) => {
            i++;
            template +=`<li>
                            <input id="search_trainee_`+i+`" class="form-check-input search-trainee-input" value="`+item.id+`" data-complete='`+JSON.stringify(item)+`' type="checkbox">
                            <label for="search_trainee_`+i+`" class="form-check-label">`+item.name+`
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

  
  $(".trainee-delete").click(function(e){
    let to_bulk = []
    $('.checkbox-trainee:checked').each(function() {
      to_bulk.push($(this).data('id'))
    });
    Swal.fire({
      // title: 'Are you sure?',
      text: "Yakin menghapus "+to_bulk.length+" peserta pelatihan tersebut?",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Ya, lanjutkan!',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batalkan',
    }).then((result) => {
      if (result.isConfirmed) {
        to_bulk.forEach(id => {
          $("#subdistrict-"+id+"-trainee").remove()
          trainees_to_delete.includes(id)?'':trainees_to_delete.push(id)
          trainees_new.includes(id)?trainees_new.splice(trainees_new.indexOf(id), 1):''
          trainees_approved.includes(id)?trainees_approved.splice(trainees_approved.indexOf(id), 1):''
          trainees_approved_not.includes(id)?trainees_approved_not.splice(trainees_approved_not.indexOf(id), 1):''
        });
        valuateDisplay()
        // console.log('trainees_to_delete',trainees_to_delete)
        Swal.fire({
          title: 'Terhapus',
          html: 'Peserta dihapus dari tampilan ini, tekan simpan untuk menyimpan perubahan',
          icon: 'success',
          showConfirmButton: false,
          timer: 1500
        })
      }
    })
  });

  $(".trainee-approve").click(function(e){
    console.log('trainee approve')
    let to_bulk = []
    $('.checkbox-trainee:checked').each(function() {
      to_bulk.push($(this).data('id'))
    });
    to_bulk.forEach(id => {
      $("#trainee-"+id+"-approved-wrap").html(`<i class="fas fa-check fa-lg text-blue-b trainee-approved" id="trainee-`+id+`-approved"></i>`)
      trainees_approved.includes(id)?'':trainees_approved.push(id)
      trainees_approved_not.includes(id)?trainees_approved_not.splice(trainees_approved_not.indexOf(id), 1):''
    })
    valuateDisplay()
    uncheck_all()
  });

  $(".trainee-approve-not").click(function(e){
    console.log('trainee approve not')
    let to_bulk = []
    $('.checkbox-trainee:checked').each(function() {
      to_bulk.push($(this).data('id'))
    });
    to_bulk.forEach(id => {
      $("#trainee-"+id+"-approved-wrap").html(``)
      trainees_approved.includes(id)?trainees_approved.splice(trainees_approved.indexOf(id), 1):''
      trainees_approved_not.includes(id)?'':trainees_approved_not.push(id)
    })
    valuateDisplay()
    uncheck_all()
  });

 

  $(".check-all").click(function(e){
    let group = $(this).data('group')
    $(".check-all-group-"+group).prop('checked',$(this).is(":checked"))
  });

  $("#btn-submit-edit").click(function(e) {
    $('#loading').show();
    $('#form').hide();
    let id = $("[name='id']").val();
    let payload = {
      trainees_new: trainees_new,
      trainees_to_delete: trainees_to_delete,
      trainees_approved: trainees_approved,
      trainees_approved_not: trainees_approved_not,
      trainees_job_titles: {} // Objek untuk menyimpan job_title
  };

    $(".checkbox-trainee").each(function () {
      const traineeId = $(this).data('id');
      const jobTitle = $(`#job_title_input_${traineeId}`).val();
      payload.trainees_job_titles[traineeId] = jobTitle;
  });
    axios.post(baseUrl + '/api/business/post-edit-trainee/' + id, payload, apiHeaders)
      .then(function(response) {
        console.log('response..', response);
        if (response.status == 200 && response.data.status) {
        Swal.fire({
          icon: 'success',
          width: 600,
          title: "Berhasil",
          // html: "...",
          confirmButtonText: 'Ya, terima kasih',
        });
        // window.location = baseUrl+'/admin-katkab/business';
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
      
  });

});
