
<div class="modal fade" id="modalCriteria" role="dialog">
  <div class="modal-dialog modal-xl" id="modalCriteria_dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Criteria Management</h5>
      </div>
      <div class="modal-body">
            <div class="col-md-12 row">
                <div class="col-md-5 border-left-primary main-criteria">
                    <form class="forms-sample" id="formCriteria">
                        <h6 class="badge-primary">Main Criteria</h6>
                        <div class="form-group" style="display: flex; flex-direction: row;">
                            <div class="form-check" style="margin-right: 20px;">
                                <input class="form-check-input" type="radio" name="criteria_type" id="normalType" value="1" onchange="changeType(1)">
                                <label class="form-check-label" for="normalType">Normal</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="criteria_type" id="withSubType" value="0" onchange="changeType(0)" checked>
                                <label class="form-check-label" for="withSubType">With Sub</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="criteria">Criteria</label>
                            <textarea class="form-control form-input" id="criteria" name="criteria" placeholder="Criteria" onchange="form_criteria.criteria = this.value" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="points">Points</label>
                            <input type="number" min="0" class="form-control form-input" id="points" name="points" onchange="changeMainPoint(this.value)" required>
                        </div>
                    </form>
                </div>
                <div class="col-md-7 border-left-success sub-criteria">
                    <h6 class="badge-success">Sub Criteria</h6>
                    <div class="col-md-12 mb-3" style="padding-left: unset;padding-right:unset;">
                        <form class="forms-sample input-group" id="formSubCriteria">
                            <div class="input-group col-md-6" style="padding-left: unset;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="sub_criteria_label">Sub Criteria</span>
                                </div>
                                <input type="text" id="sub_criteria" class="form-control" placeholder="Sub Criteria" aria-label="Criteria" aria-describedby="sub_criteria_label" required>
                            </div>
                            <div class="input-group col-md-4" style="padding-left: unset;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="sub_points_label">Points</span>
                                </div>
                                <input type="number" id="sub_points" min="1" max="100" class="form-control" aria-describedby="sub_points_label" placeholder="Points" required>
                            </div>
                            <div class="input-group-btn col-md-2" style="padding-left: unset;padding-right:unset;">
                                <button type="submit" class="btn btn-sm btn-block btn-outline-primary mt-1" id="btn_submit_sub"><span class="fa fa-plus-circle"></span> Add</button>
                            </div>
                        </form>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sub Critera</th>
                                <th>Points</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tblSubCriteria_tbody"></tbody>
                    </table>
                </div>
            </div>
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
    let isUpdate = false;
    var criteria_data = [];
    var form_criteria = {
        ch_id:0,
        criteria:"",
        points:0,
        is_normal:0,
        details:[],
        deleted_criterias:[]
    };

    $(document).ready(function(){
    });

    function changeType(val){

        form_criteria.is_normal = val;
        if(val == 1){
            $("#modalCriteria_dialog").removeClass('modal-xl');
            $(".sub-criteria").hide();
            $(".main-criteria").removeClass('col-md-5').addClass('col-md-12');
        }else{
            $("#modalCriteria_dialog").addClass('modal-xl');
            $(".main-criteria").removeClass('col-md-12').addClass('col-md-5');
            $(".sub-criteria").show();
        }
    }

    function renderCriteriaData(){ 

        var params = `WHERE event_id = '${event_id}'`;
        var tbody_tr = '';
        criteria_data = [];
        $.post("ajax/get_event_criterias.php",{
            params:params
        },function(data,status){
            var res = JSON.parse(data);
            console.log(res.data);
            for (let chIndex = 0; chIndex < res.data.length; chIndex++) {
                const chRow = res.data[chIndex];
                criteria_data[chIndex] = chRow;
                tbody_tr += `<tr>
                    <th>${chIndex+1}</th>
                    <th colspan="2">${chRow.criteria}</th>
                    <th>${chRow.points}</th>
                    <th>
                        <button type="button" class="btn btn-warning btn-rounded btn-icon btn-sm" onclick="editCriteriaModal(${chIndex})"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-danger btn-rounded btn-icon btn-sm" onclick="deleteCriteriaEntry(${chRow.ch_id})"><i class="fas fa-trash"></i></button>
                    </th>
                </tr>`;
                if(chRow.is_normal == 0){
                    for (let chDetailsIndex = 0; chDetailsIndex < chRow.details.length; chDetailsIndex++) {
                        const chDetailsRow = chRow.details[chDetailsIndex];
                        tbody_tr += `<tr>
                            <td></td>
                            <td></td>
                            <td>${chDetailsRow.criteria}</td>
                            <td>${chDetailsRow.points}</td>
                            <td></td>
                        </tr>`;
                    }
                }
            }
            $("#tblCriteria tbody").html(tbody_tr);
            if($("#event_status").val() != 'S'){
                $("#tblCriteria th:nth-child(4)").hide();
                $("#tblCriteria td:nth-child(5)").hide();
            }
        });
    }
    function addCriteriaModal(){
        isUpdate = false;
        resetFormCriteria();
        getSubCriteria();

        // $(".modal-title").html("Add Entry");
        $("#modalCriteria").modal('show');
        $('#formCriteria')[0].reset();

        // RESET SUB 
        $("#btn_submit_sub").prop("disabled",true);
    }

    function editCriteriaModal(index) {
        isUpdate = true;
        resetFormCriteria();

        var ch_data = criteria_data[index];
        form_criteria.ch_id = ch_data.ch_id;
        form_criteria.criteria = ch_data.criteria;
        form_criteria.points = ch_data.points * 1;
        form_criteria.is_normal = ch_data.is_normal * 1;

        for (let chDetailsIndex = 0; chDetailsIndex < ch_data.details.length; chDetailsIndex++) {
            const chDetailsRow = ch_data.details[chDetailsIndex];
            var criteria = {
                name:chDetailsRow.criteria,
                points:chDetailsRow.points * 1,
                criteria_id:chDetailsRow.criteria_id
            };
            form_criteria.details.push(criteria);
        }

        getSubCriteria();
        
        $("#criteria").html(ch_data.criteria);
        $("#points").val(ch_data.points);

        if(form_criteria.is_normal == 1){
            $("#normalType").prop("checked",true);
            $("#withSubType").prop("checked",false);
        }else{
            $("#normalType").prop("checked",false);
            $("#withSubType").prop("checked",true);
        }
        changeType(form_criteria.is_normal);
        $("#modalCriteria").modal('show');
    }

    $("#formCriteria").submit(function(e) {
        e.preventDefault();

        if(form_criteria.is_normal == 1){
            addCriteria();
        }else{
            if(form_criteria.details.length > 0){

                let totalPoints = 0;
                for (let detail of form_criteria.details) {
                    totalPoints += detail.points;
                }

                if(totalPoints != form_criteria.points){
                    swal_info("Criteria Management","The points for the Sub Criteria must be equal to the points for the Main Criteria.");
                }else{
                    addCriteria();
                }
            }else{
                $("#sub_criteria").focus();
                swal_info("Criteria Management","Please add details first.");
            }
        }
    });

    function addCriteria(){
        var form_data = JSON.stringify(form_criteria);
        $("#btn_submit_criteria")
            .prop("disabled",true)
            .html("<span class='fa fa-spin fa-spinner'></span> Loading");

        $.post("ajax/add_event_criteria.php", {
            data:form_data
        }, function(data, status) {
            if(data == 1){
                isUpdate > 0 ? success_update("Criteria"):  success_add("Criteria");
            }
            $("#modalCriteria").modal('hide');
            renderCriteriaData();
            $("#btn_submit_criteria").prop("disabled",false).html("<span class='fa fa-check-circle'></span> Submit");
        });
    }

    function deleteCriteriaEntry(ch_id){
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
                    ch_id:ch_id
                }, function(data, status) {
                    if(data == 1){
                        success_delete("Criteria Management");
                    }
                    renderCriteriaData();
                });
            } else {
            }
        });
    }


    // SUB CRITERIA
    $("#formSubCriteria").submit(function(e) {
        e.preventDefault();

        var sub_criteria = $("#sub_criteria").val();
        var sub_points = $("#sub_points").val() * 1;

        let totalPoints = 0;

        for (let detail of form_criteria.details) {
            totalPoints += detail.points;
        }

        if(totalPoints + sub_points > form_criteria.points){
            swal_info("Criteria Management","The points for the Sub Criteria already exceeds");
        }else{
            var criteria = {
                name:sub_criteria,
                points:sub_points,
                criteria_id:0
            };

            form_criteria.details.push(criteria);
            $("#sub_criteria").val('');
            $("#sub_points").val('');
            getSubCriteria();
        }
    });

    function getSubCriteria(){
        $("#tblSubCriteria_tbody").html("");
        var sub_criterias = form_criteria.details;
        if(sub_criterias.length > 0){
            for (let scIndex = 0; scIndex < sub_criterias.length; scIndex++) {
                const scRow = sub_criterias[scIndex];
                $("#tblSubCriteria_tbody").append(`<tr>
                    <td>${scIndex+1}</td>
                    <td>${scRow.name}</td>
                    <td>${scRow.points}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteSubCriteria(${scIndex},${scRow.criteria_id})">
                            <span class="fa fa-trash"></span>
                        </button>
                    </td>
                </tr>`);
            }
        }else{
            $("#tblSubCriteria_tbody").html('<tr><td colspan="4">No Records found.</td></tr>');
        }
    }

    function deleteSubCriteria(indexToDelete, criteria_id){
        if(criteria_id > 0){
            form_criteria.deleted_criterias.push(criteria_id);
        }
        form_criteria.details.splice(indexToDelete, 1);
        getSubCriteria();
    }

    function resetFormCriteria(){
        form_criteria = {
            ch_id:0,
            event_id:event_id,
            criteria:"",
            points:0,
            is_normal:0,
            details:[],
            deleted_criterias:[]
        };
    }

    function changeMainPoint(value){
        if(value > 0){
            form_criteria.points = value * 1;
            $("#btn_submit_sub").prop("disabled",false);
        }else{
            $("#btn_submit_sub").prop("disabled",true);
        }
    }
</script>