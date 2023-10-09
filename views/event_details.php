<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="jumbotron bg-gradient-etally2">
        <h1 id="event_name"></h1>
        <p></p>
        <input type="text" id="event_id" value="<?=$_GET['event_id']?>">
    </div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#criteria">Criteria</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#menu1">Participants</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#menu2">Judges</a>
    </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
    <div class="tab-pane active container" id="criteria">
        <div class="row">
            <div class="card shadow mt-4 col border-left-success">
                <div class="card-body">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">&nbsp;</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm" onclick="addCriteriaModal()">
                            <i class="fas fa-plus-circle fa-sm"></i> Add Record
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tblCriteria" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Criteria</th>
                                    <th>Points</th>
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
    </div>
    <div class="tab-pane container" id="menu1">ss</div>
    <div class="tab-pane container" id="menu2">
        sadsas
    
    .</div>
    </div>
</div>
<div class="modal fade" id="modalCriteria" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add</h5>
      </div>
      <div class="modal-body">
        <form class="forms-sample" id="formCriteria">
            <input type="text" name="event_id" id="criteria_event_id" class="form-input">
            <input type="text" name="criteria_id" id="criteria_id" class="form-input">
          <div class="form-group">
            <label for="criteria">Criteria</label>
            <textarea class="form-control form-input" id="criteria" name="criteria" placeholder="Criteria" required></textarea>
          </div>
          <div class="form-group">
            <label for="points">Points</label>
            <input type="number" min="0" class="form-control form-input" id="points" name="points" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-outline-success" form="formCriteria" type="submit" id="btn_submit_criteria">
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
    var table_criteria;
    var event_id = <?=$_GET['event_id']?>;
    $(document).ready(function(){
        getEventData();
        renderCriteriaData();
    });
</script>
<script>
    $(document).ready(function(){

        $('#tblCriteria tbody').on('click', '.btn-update-data', function() {
            var data = table_criteria.row($(this).closest('tr')).data();
            editCriteriaModal(data);
            // You can access and use the data as needed
        });
    });
    function getEventData(){
        var params = `WHERE event_id = '${event_id}'`;
        $.post("ajax/get_events.php",{
            params:params
        },function(data,status){
            var res = JSON.parse(data);
            var event_data = res.data[0];
            $("#event_name").html(event_data.event_name);
        });
    }

    function renderCriteriaData(){ 
        $('#tblCriteria').DataTable().destroy();
        table_criteria = $("#tblCriteria").DataTable({
            ajax: "ajax/get_event_criterias.php",
            columns: [
                { data: 'criteria_id' },
                { data: 'criteria' },
                { data: 'points' },
                {
                mRender: function(data, type, row) {
                    return `<button type="button" class="btn btn-warning btn-rounded btn-icon btn-sm btn-update-data"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-rounded btn-icon btn-sm" onclick="deleteEntry(${row.event_id})"><i class="fas fa-trash"></i></button>`;
                }
                },
            ]
        });
    }
    function addCriteriaModal(){
        $(".modal-title").html("Add Entry");
        $("#modalCriteria").modal('show');
        $('#formCriteria')[0].reset();
        $("#criteria_event_id").val(event_id);
    }

    function editCriteriaModal(form_data) {
        $(".modal-title").html("Edit Entry");
        $('#formCriteria .form-input').each(function(index) {
            // 'this' refers to the current element in the loop
            var currentElement = $(this);
            var current_id = currentElement.attr('id');
            $(this).val(form_data[current_id]);
        });
        $("#criteria_event_id").val(event_id);
        $("#modalCriteria").modal('show');
    }

    $("#formCriteria").submit(function(e) {
        e.preventDefault();
        var form_data = $(this).serialize();
        console.log(form_data);
        $("#btn_submit_criteria").prop("disabled",true).html("<span class='fa fa-spin fa-spinner'></span> Loading");
        $.post("ajax/add_event_criteria.php", form_data, function(data, status) {
        if(data == 1){
            $("#criteria_id").val() > 0 ? success_update("Criteria"):  success_add("Criteria");
        }
        $("#modalCriteria").modal('hide');
        renderCriteriaData();
        $("#btn_submit_criteria").prop("disabled",false).html("<span class='fa fa-check-circle'></span> Submit");
        });
    });
</script>

