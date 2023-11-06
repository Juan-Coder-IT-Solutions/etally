<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Participants</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm" onclick="addModal()">
        <i class="fas fa-plus-circle fa-sm"></i> Add Record
    </a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4 border-left-success">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="tblEntry" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th></th>
                        <th>Fullname</th>
                        <th>Year</th>
                        <th>Program</th>
                        <th>Event</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEntry" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add</h5>
      </div>
      <div class="modal-body">
        <form class="forms-sample" id="formEntry" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-6">
            <center>
            <img id="image-preview" class="img-account-profile rounded-circle mb-2" src="assets/img/profiles/user.png" alt="" style="width: 300px; height: 300px;">
          </center>
          </div>
            <div class="col-md-6">
            <input type="hidden" name="participant_id" id="participant_id" class="form-input">
            <div class="form-group">
              <label for="participant_name">Participant Name</label>
              <input type="text" class="form-control form-input" id="participant_name" name="participant_name" placeholder="Participant Name"
                required>
            </div>
            <div class="form-group">
              <label for="participant_img">Participant Image</label>
              <input class="form-control" type="file" name="participant_img" id="participant_img" accept="image/jpeg, image/png" onchange="previewImage(event)" required />
            </div>
            <div class="form-group">
              <label for="participant_year">Year</label>
              <select name="participant_year" id="participant_year" class="form-control form-input select2" style="width: 100%;" required>
                <option value="">Please Select</option>
                <option value="First Year">First Year</option>
                <option value="Second Year">Second Year</option>
                <option value="Third Year">Third Year</option>
                <option value="Fourth Year">Fourth Year</option>
              </select>
            </div>
            <div class="form-group">
              <label for="program_id">Program Name</label>
              <select name="program_id" id="program_id" class="form-control select2" style="width: 100%;" required>
              </select>
            </div>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-outline-success" form="formEntry" type="submit" id="btn_submit">
            <span class="fa fa-check-circle"></span> Submit
        </button>
        <button class="btn btn-sm btn-outline-danger" data-dismiss="modal">
            <span class="fa fa-times-circle"></span> Close
        </button>
      </div>
    </div>
  </div>
</div>
<script>
    var table;
$(document).ready(function() {
    renderData();

    $('#tblEntry tbody').on('click', '.btn-update-data', function() {
        var data = table.row($(this).closest('tr')).data();
        editModal(data);
        // You can access and use the data as needed
    });
});

function previewImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const imagePreview = document.getElementById('image-preview');
            imagePreview.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function addModal() {
  $("#participant_id").val(0);
  $(".modal-title").html("Add Entry");
  $("#modalEntry").modal('show');
  $('#formEntry')[0].reset();
  renderSelectPrograms();
  $(".select2").select2();
  $("#participant_img").prop({"required":true}).val('');
  const imagePreview = document.getElementById('image-preview');
  imagePreview.src = "assets/img/profiles/user.png";
}

  
function renderSelectPrograms(program_id){
  $("#program_id").html("<option value=''> Please Select </option>");
  $.post("ajax/get_programs.php",{},function(data,status){
      var res = JSON.parse(data);
      console.log(res.data);
      for (let programIndex = 0; programIndex < res.data.length; programIndex++) {
        const program_row = res.data[programIndex];
        var selected = program_row.program_id == program_id ? "selected":'';
        $("#program_id").append(`<option ${selected} value='${program_row.program_id}'>${program_row.program_name}</option>`);
      }
  });
}

function editModal(form_data) {
  renderSelectPrograms(form_data.program_id);
  $(".modal-title").html("Edit Entry");
  $('.form-input').each(function(index) {
    // 'this' refers to the current element in the loop
    var currentElement = $(this);
    var current_id = currentElement.attr('id');
    $(this).val(form_data[current_id]);
  });
  $("#participant_img").prop({"required":false}).val('');
  $("#modalEntry").modal('show');
  $(".select2").select2();
  const imagePreview = document.getElementById('image-preview');
  imagePreview.src = "assets/img/profiles/"+form_data.participant_img;
}

function deleteEntry(participant_id){
  Swal.fire({
    icon: 'question',
    title: 'Participants',
    text: 'Are you sure to delete entry?',
    showCancelButton: true,
    allowOutsideClick: false
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      $.post("ajax/delete_participant.php", {
        participant_id:participant_id
      }, function(data, status) {
        if(data == 1){
          success_add("Participants");
        }
        renderData();
      });
    } else {
    }
  });
}

function renderData(){ 
  $('#tblEntry').DataTable().destroy();
  table = $("#tblEntry").DataTable({
      ajax: "ajax/get_participants.php",
      columns: [
        {
          mRender: function(data, type, row) {
            return `<input type="checkbox" value="${row.participant_id}">`;
          }
        },
        { 
            mRender:function(data,type,row){
                return `<img class="img-rounded" src="assets/img/profiles/${row.participant_img}" alt="Image" style="width: 50px;">`;
            }
         },
        { data: 'participant_name' },
        { data: 'participant_year' },
        { data: 'program_name' },
        { data: 'events' },
        {
          mRender: function(data, type, row) {
            return `<button type="button" class="btn btn-warning btn-rounded btn-icon btn-sm btn-update-data"><i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-danger btn-rounded btn-icon btn-sm" onclick="deleteEntry(${row.participant_id})"><i class="fas fa-trash"></i></button>`;
          }
        },
      ]
    });
}

$("#formEntry").submit(function(e) {
    e.preventDefault();
  
    var formData = new FormData(this);
    $("#btn_submit").prop("disabled",true).html("<span class='fa fa-spin fa-spinner'></span> Loading");
    $.ajax({
      type: "POST",
      url: "ajax/add_participant.php",
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        if(response == 1){
          $("#participant_id").val() > 0 ? success_update("Participants"):  success_add("Participants");
        }else if(response == 2){
          swal_error("Participants","Username already exist.");
        }else{

        }
        $("#modalEntry").modal('hide');
        renderData();
        $("#btn_submit").prop("disabled",false).html("<span class='fa fa-check-circle'></span> Submit");
      }
    });
});
</script>