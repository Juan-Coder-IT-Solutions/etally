
<div class="modal fade" id="modalCriteria" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add</h5>
      </div>
      <div class="modal-body">
        <form class="forms-sample" id="formCriteria">
            <input type="hidden" name="event_id" id="criteria_event_id" class="form-input">
            <input type="hidden" name="criteria_id" id="criteria_id" class="form-input">
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
    $(document).ready(function(){

        $('#tblCriteria tbody').on('click', '.btn-update-criteria-data', function() {
            var data = table_criteria.row($(this).closest('tr')).data();
            editCriteriaModal(data);
            // You can access and use the data as needed
        });
    });

    function renderCriteriaData(){ 
        $('#tblCriteria').DataTable().destroy();
        table_criteria = $("#tblCriteria").DataTable({
            "ajax": {
                "type":"POST",
				"url": "ajax/get_event_criterias.php",
				"dataSrc": "data",
                "data":{
                    params: `WHERE event_id = '${event_id}'`
                },
			},
            columns: [
                { data: 'criteria_id' },
                { data: 'criteria' },
                { data: 'points' },
                {
                mRender: function(data, type, row) {
                    return `<button type="button" class="btn btn-warning btn-rounded btn-icon btn-sm btn-update-criteria-data"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-rounded btn-icon btn-sm" onclick="deleteCriteriaEntry(${row.criteria_id})"><i class="fas fa-trash"></i></button>`;
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

    function deleteCriteriaEntry(criteria_id){
        Swal.fire({
            icon: 'question',
            title: 'Criteria',
            text: 'Are you sure to delete entry?',
            showCancelButton: true,
            allowOutsideClick: false
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.post("ajax/delete_event_criteria.php", {
                    criteria_id:criteria_id
                }, function(data, status) {
                    if(data == 1){
                        success_delete("Criteria");
                    }
                    renderCriteriaData();
                });
            } else {
            }
        });
    }
</script>