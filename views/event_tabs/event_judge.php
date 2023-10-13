<div class="modal fade" id="modalJudge" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add</h5>
      </div>
      <div class="modal-body">
        <form class="forms-sample" id="formJudge">
            <input type="text" name="event_id" id="judge_event_id" class="form-input">
            <input type="text" name="event_judge_id" id="event_judge_id" class="form-input">
          <div class="form-group">
            <label for="judge_ids">Judge Name</label>
            <select name="judge_ids[]" id="judge_ids" class="form-control" multiple="multiple" style="width: 100%;">
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-outline-success" form="formJudge" type="submit" id="btn_submit_judge">
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
    var judge_ids = [];
    $(document).ready(function(){

        $('#tblJudge tbody').on('click', '.btn-update-judge-data', function() {
            var data = table_judge.row($(this).closest('tr')).data();
            editJudgeModal(data);
            // You can access and use the data as needed
        });
    });

    function renderJudgeData(){

        var params = `WHERE event_id = '${event_id}'`;
        var tbody_tr = '';
        judge_ids = [];
        $.post("ajax/get_event_judges.php",{
            params:params
        },function(data,status){
            var res = JSON.parse(data);
            console.log(res.data);
            for (let judgeIndex = 0; judgeIndex < res.data.length; judgeIndex++) {
                const judgeElem = res.data[judgeIndex];
                judge_ids.push(judgeElem.judge_id);
                tbody_tr += `<tr>
                    <td>${judgeElem.judge_no}</td>
                    <td>${judgeElem.judge_name}</td>
                    <td></td>
                </tr>`;
            }
            $("#tblJudge tbody").html(tbody_tr);
        });


        // $('#tblJudge').DataTable().destroy();
        // table_judge = $("#tblJudge").DataTable({
        //     ajax: "ajax/get_event_judges.php",
        //     searching:false,
        //     sorting:false,
        //     paging:false,
        //     bInfo:false,
        //     columns: [
        //         { data: 'event_judge_id' },
        //         { data: 'judge_name' },
        //         {
        //             mRender: function(data, type, row) {
        //                 return `<button type="button" class="btn btn-warning btn-rounded btn-icon btn-sm btn-update-judge-data"><i class="fas fa-edit"></i></button>
        //                 <button type="button" class="btn btn-danger btn-rounded btn-icon btn-sm" onclick="deleteJudgeEntry(${row.event_judge_id})"><i class="fas fa-trash"></i></button>`;
        //             }
        //         },
        //     ]
        // });
    }
    function addJudgeModal(){
        $(".modal-title").html("Add Entry");
        $("#modalJudge").modal('show');
        $('#formJudge')[0].reset();
        $("#judge_event_id").val(event_id);
        get_judges();
    }

    function get_judges()
    {
        var option_judge = "<option value=''> &mdash; Please Select &mdash; </option>";
        $.post("ajax/get_judges.php",{},function(data,status){
            var res = JSON.parse(data);
            for (let judgeIndex = 0; judgeIndex < res.data.length; judgeIndex++) {
                const judgeElem = res.data[judgeIndex];
                var selected = judge_ids.includes(judgeElem.judge_id) ? "selected" : "";
                option_judge += `<option value='${judgeElem.judge_id}' ${selected}> ${judgeElem.judge_name} </option>`;
            }
            $("#judge_ids").html(option_judge).select2();
        });
    }

    function editJudgeModal(form_data) {
        $(".modal-title").html("Edit Entry");
        $('#formJudge .form-input').each(function(index) {
            // 'this' refers to the current element in the loop
            var currentElement = $(this);
            var current_id = currentElement.attr('id');
            $(this).val(form_data[current_id]);
        });
        $("#judge_event_id").val(event_id);
        $("#modalJudge").modal('show');
    }

    $("#formJudge").submit(function(e) {
        e.preventDefault();
        var form_data = $(this).serialize();
        console.log(form_data);
        $("#btn_submit_judge").prop("disabled",true).html("<span class='fa fa-spin fa-spinner'></span> Loading");
        $.post("ajax/add_event_judges.php", form_data, function(data, status) {
            if(data == 1){
                success_update("Event Judges");
            }
            $("#modalJudge").modal('hide');
            renderJudgeData();
            $("#btn_submit_judge").prop("disabled",false).html("<span class='fa fa-check-circle'></span> Submit");
        });
    });

    function deleteJudgeEntry(event_judge_id){
        Swal.fire({
            icon: 'question',
            title: 'Event Judges',
            text: 'Are you sure to delete entry?',
            showCancelButton: true,
            allowOutsideClick: false
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.post("ajax/delete_event_judge.php", {
                    event_judge_id:event_judge_id
                }, function(data, status) {
                    if(data == 1){
                        success_delete("judge");
                    }
                    renderJudgeData();
                });
            } else {
            }
        });
    }
</script>