<div class="container-fluid">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Judges</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm" onclick="addModal()">
        <i class="fas fa-plus-circle fa-sm"></i> Add Record
    </a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="tblEntry" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th></th>
                        <th>Name</th>
                        <th>Affiliation</th>
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
            <input type="hidden" name="judge_id" id="judge_id" class="form-input">
          <div class="form-group">
            <label for="judge_name">Judge Name</label>
            <input type="text" class="form-control form-input" id="judge_name" name="judge_name" placeholder="Account Name"
              required>
          </div>
          <div class="form-group">
            <label for="judge_affiliation">Affiliation</label>
            <textarea class="form-control form-input" id="judge_affiliation" name="judge_affiliation" placeholder="Affiliation" required></textarea>
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
  $(".modal-title").html("Add Entry");
  $("#modalEntry").modal('show');
  $('#formEntry')[0].reset();
}

function editModal(form_data) {
  $(".modal-title").html("Edit Entry");
  $('.form-input').each(function(index) {
    // 'this' refers to the current element in the loop
    var currentElement = $(this);
    var current_id = currentElement.attr('id');
    $(this).val(form_data[current_id]);
  });
  $("#modalEntry").modal('show');
}

function deleteEntry(judge_id){
  Swal.fire({
			icon: 'question',
			title: 'Judges',
			text: 'Are you sure to delete entry?',
			showCancelButton: true,
			allowOutsideClick: false
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
        $.post("ajax/delete_judge.php", {
            judge_id:judge_id
        }, function(data, status) {
          if(data == 1){
            success_add("Judges");
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
      ajax: "ajax/get_judges.php",
      columns: [
        {
          mRender: function(data, type, row) {
            return `<input type="checkbox" value="${row.judge_id}">`;
          }
        },
        { 
            mRender:function(data,type,row){
                return `<img class="img-rounded" src="assets/img/undraw_profile.svg" alt="Image" style="width: 30px;">`;
            }
         },
        { data: 'judge_name' },
        { data: 'judge_affiliation' },
        {
          mRender: function(data, type, row) {
            return `<button type="button" class="btn btn-warning btn-rounded btn-icon btn-sm btn-update-data"><i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-danger btn-rounded btn-icon btn-sm" onclick="deleteEntry(${row.judge_id})"><i class="fas fa-trash"></i></button>`;
          }
        },
      ]
    });
}

$("#formEntry").submit(function(e) {
    e.preventDefault();
    var form_data = $(this).serialize();
    console.log(form_data);
    $("#btn_submit").prop("disabled",true).html("<span class='fa fa-spin fa-spinner'></span> Loading");
    $.post("ajax/add_judge.php", form_data, function(data, status) {
      if(data == 1){
        $("#judge_id").val() > 0 ? success_update("Judges"):  success_add("Judges");
      }
      $("#modalEntry").modal('hide');
      renderData();
      $("#btn_submit").prop("disabled",false).html("<span class='fa fa-check-circle'></span> Submit");
    });
});
</script>