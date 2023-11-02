<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Programs</h1>
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
                            <th>Program Name</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEntry" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add</h5>
      </div>
      <div class="modal-body">
          <form class="forms-sample" id="formEntry">
            <input type="hidden" name="program_id" id="program_id" class="form-input">
            <div class="form-group">
              <label for="program_name">Program Name</label>
              <input type="text" class="form-control form-input" id="program_name" name="program_name" placeholder="Program Name"
                required>
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

  function addModal() {
    // previewPDF(false);
    $("#program_id").val(0);
    $(".modal-title").html("Add Entry");
    $("#modalEntry").modal('show');
    $('#formEntry')[0].reset();
    $("#event_mechanics").prop("required",true);
  }

  function editModal(form_data) {
    $(".modal-title").html("Edit Entry");
    $('.form-input').each(function(index) {
      // 'this' refers to the current element in the loop
      var currentElement = $(this);
      var current_id = currentElement.attr('id');
      $(this).val(form_data[current_id]);
    });
              
    $("#event_mechanics").prop({"required":false}).val('');
    $("#modalEntry").modal('show');
  }

  function deleteEntry(event_id){
    Swal.fire({
        icon: 'question',
        title: 'Events',
        text: 'Are you sure to delete entry?',
        showCancelButton: true,
        allowOutsideClick: false
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          $.post("ajax/delete_event.php", {
              event_id:event_id
          }, function(data, status) {
            if(data == 1){
              success_add("Events");
            }
            renderData();
          });
        } else {
        }
      });
  }

  function viewEntry(event_id){
      window.location = "index.php?page=event-details&event_id="+event_id;
  }

  function renderData(){ 
    $('#tblEntry').DataTable().destroy();
    table = $("#tblEntry").DataTable({
        ajax: "ajax/get_programs.php",
        columns: [
          { data: 'count' },
          { data: 'program_name' },
          { data: 'date_added' },
          {
            mRender: function(data, type, row) {
              return `<button type="button" class="btn btn-warning btn-rounded btn-icon btn-sm btn-update-data" title="Edit Program Name"><i class="fas fa-edit"></i></button>
              <button type="button" class="btn btn-danger btn-rounded btn-icon btn-sm" onclick="deleteEntry(${row.program_id})" title="Delete Program Name"><i class="fas fa-trash"></i></button>`;
            }
          },
        ]
      });
  }

  function viewMechanics(event_id){
    $("#uploadModal").modal('show');
  }

  $("#formEntry").submit(function(e) {
      e.preventDefault();

      var formData = new FormData(this);
      $("#btn_submit").prop("disabled",true).html("<span class='fa fa-spin fa-spinner'></span> Loading");
      $.post("ajax/add_program.php",$("#formEntry").serialize(),function(response,data){
        if(response == 1){
            $("#program_id").val() > 0 ? success_update("Program Name"):  success_add("Program Name");
          }
          $("#modalEntry").modal('hide');
          renderData();
          $("#btn_submit").prop("disabled",false).html("<span class='fa fa-check-circle'></span> Submit");
      });
  });
</script>