<div class="container-fluid">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Judges</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm" onclick="addJudgeModal()">
        <i class="fas fa-plus-circle fa-sm"></i> Add Record
    </a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="tblJudges" width="100%" cellspacing="0">
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
<div class="modal fade" id="judgeModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Add</h5>
      </div>
      <div class="modal-body">
        <form class="forms-sample" id="judgeForm">
            <input type="text" name="judge_id" id="judge_id" class="form-input">
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
        <button class="btn btn-sm btn-outline-success" form="judgeForm" type="submit">
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

    $('#tblJudges tbody').on('click', '.btn-update-data', function() {
        var data = table.row($(this).closest('tr')).data();
        editJudgeModal(data);
        // You can access and use the data as needed
    });
});

function addJudgeModal() {
    $("#judgeModal").modal('show');
    $('#judgeForm')[0].reset();
}

function editJudgeModal(form_data) {
    $('.form-input').each(function(index) {
        // 'this' refers to the current element in the loop
        var currentElement = $(this);
        var current_id = currentElement.attr('id');
        $(this).val(form_data[current_id]);
    });
    $("#judgeModal").modal('show');
}

function deleteJudge(judge_id){
    $.post("ajax/delete_judge.php", {
        judge_id:judge_id
    }, function(data, status) {
        renderData();
    });
}

function renderData(){ 
  $('#tblJudges').DataTable().destroy();
  table = $("#tblJudges").DataTable({
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
            <button type="button" class="btn btn-danger btn-rounded btn-icon btn-sm" onclick="deleteJudge(${row.judge_id})"><i class="fas fa-trash"></i></button>`;
          }
        },
      ]
    });
}

$("#judgeForm").submit(function(e) {
    e.preventDefault();
    var form_data = $(this).serialize();
    console.log(form_data);
    $.post("ajax/add_judge.php", form_data, function(data, status) {
        $("#judgeModal").modal('hide');
        renderData();
    });
});
</script>