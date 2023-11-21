
    <!-- DataTales Example -->
    <div style="background-color: #ffc254;padding: 5px;border-radius: 6px;color: #fff;margin-bottom: 7px;">
        <h1 id="event_name"></h1>
        <p id="event_description"></p>
        <input type="hidden" id="event_id" value="<?=$_GET['event_id']?>">
        <input type="hidden" id="event_status">
    </div>

    <div class="d-sm-flex mb-4">
        <h1 class="h3 mb-0 text-gray-800">&nbsp;</h1>
        <button id="btn_event_timer" style="display: none;" class="btn btn-sm btn-outline-warning shadow-sm mr-1" onclick="setTimer()">
            <span class="fa fa-clock"></span> Set Timer
        </button>
        <button id="btn_event_status" class="btn btn-sm btn-outline-success shadow-sm"></button>
    </div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item" onclick="renderTabulationData()">
            <a class="nav-link active" data-toggle="tab" href="#tabulation">Tabulation</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#mechanics">Mechanics</a>
        </li>
        <li class="nav-item" onclick="renderCriteriaData(),showHideButtons()">
            <a class="nav-link" data-toggle="tab" href="#criteria_tab">Criteria</a>
        </li>
        <li class="nav-item" onclick="renderParticipantData(),showHideButtons()">
            <a class="nav-link" data-toggle="tab" href="#participants">Participants</a>
        </li>
        <li class="nav-item" onclick="renderJudgeData(),showHideButtons()">
            <a class="nav-link" data-toggle="tab" href="#judges">Judges</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active container" id="tabulation">
            <div class="row">
                <div class="card shadow mt-4 col border-left-success">
                    <div class="card-header">
                        <h5>Overall Score</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4"  id="tabulation_resolve">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tblTabulation" cellspacing="0" width="100%">
                                <thead style="text-align: center;">
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="d-sm-flex col-md-12 center" id="resolver"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card shadow mt-4 col border-left-success">
                    <div class="card-header">
                        <h5>Score per Judges</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-md-6 d-sm-flex align-items-center justify-content-between mb-4">
                            <select name="judge_name" id="judge_select" class="form-control" onchange="renderTabulationJudgeData()"></select>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tblJudgeTabulation" cellspacing="0" width="100%">
                                <thead style="text-align: center;">
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane container" id="mechanics">
            <div class="pdfviewer"></div>
        </div>
        <div class="tab-pane container" id="criteria_tab">
            <div class="row">
                <div class="card shadow mt-4 col border-left-success">
                    <div class="card-body">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4 btn-events">
                            <h1 class="h3 mb-0 text-gray-800">&nbsp;</h1>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm btn-event-saved" onclick="addCriteriaModal()">
                                <i class="fas fa-plus-circle fa-sm"></i> Add Record
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tblCriteria" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th colspan="2">Criteria</th>
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
        <div class="tab-pane container" id="participants">
            <div class="row">
                <div class="card shadow mt-4 col border-left-success">
                    <div class="card-body">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4 btn-events">
                            <h1 class="h3 mb-0 text-gray-800">&nbsp;</h1>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm btn-event-saved" onclick="addParticipantModal()">
                                <i class="fas fa-check-circle fa-sm"></i> Manage Event Participants
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tblParticipant" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Participant #</th>
                                        <th>Fullname</th>
                                        <th>Year</th>
                                        <th>Program</th>
                                        <th>Image</th>
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
        <div class="tab-pane container" id="judges">
            <div class="row">
                <div class="card shadow mt-4 col border-left-success">
                    <div class="card-body">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4 btn-events">
                            <h1 class="h3 mb-0 text-gray-800">&nbsp;</h1>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm btn-event-saved" onclick="addJudgeModal()">
                                <i class="fas fa-check-circle fa-sm"></i> Manage Event Judges
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tblJudge" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Judge #</th>
                                        <th>Judge Name</th>
                                        <th>Title</th>
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
    </div>
<style>
    .champion{
        background: #3a9b4c;
        color: #fff;
    }
    .trophy{
        float: right;
        color: gold;
    }
</style>
<script>
    var table_criteria,table_judges;
    var event_id = <?=$_GET['event_id']?>;
    $(document).ready(function(){
        getEventData();
        renderCriteriaData();
        renderJudgeData();
        renderParticipantData();
        showHideButtons();
    });

    function getEventData(){
        var params = `WHERE event_id = '${event_id}'`;
        $.post("ajax/get_events.php",{
            params:params
        },function(data,status){
            var res = JSON.parse(data);
            var event_data = res.data[0];
            $("#event_status").val(event_data.event_status);
            $("#event_name").html(event_data.event_name);
            $("#event_description").html(event_data.event_description);
            $(".pdfviewer").html(`<object id="preview" data="assets/img/mechanics/${event_data.event_mechanics}" type="application/pdf" width="100%" height="500">
                <p>This browser does not support PDFs. Please download the PDF to view it: <a href="" id="downloadLink" target="_blank">Download PDF</a>.</p>
              </object>`);

            $("#btn_event_timer").hide();
            if(event_data.event_status == 'S'){
                $("#btn_event_status").html('<i class="fas fa-play fa-sm"></i> Start Event').attr("onclick","startEvent()");
            }else if(event_data.event_status == 'P'){
                $("#btn_event_status").html('<i class="fas fa-stop fa-sm"></i> Finish Event').attr("onclick","finishEvent()");
               $("#btn_event_timer").show();
            }else{
                $("#btn_event_status").remove();
                $(".btn-events").remove();
            }
        });
    }

    function startEvent(){
        Swal.fire({
            icon: 'info',
            title: 'Events',
            text: 'Are you sure to start event?',
            showCancelButton: true,
            allowOutsideClick: false
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.post("ajax/start_event.php", {
                    event_id:event_id
                }, function(data, status) {
                    if(data == 1){
                        success_update("Event");
                    }else if(data == -1){
                        swal_warning("Event Criteria","Please encode a criteria.");
                    }
                    getEventData();
                    showHideButtons();
                    // renderJudgeData();
                });
            } else {
            }
        });
    }

    function finishEvent(){
        Swal.fire({
            icon: 'info',
            title: 'Events',
            text: 'Are you sure to finish event?',
            showCancelButton: true,
            allowOutsideClick: false
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.post("ajax/finish_event.php", {
                    event_id:event_id
                }, function(data, status) {
                    if(data == 1){
                        success_update("Event");
                    }else if(data == -1){
                        swal_warning("Judges Evaluation","Please make sure all judges have finished their evaluations.");
                    }
                    getEventData();
                    renderTabulationData();
                    // renderJudgeData();
                });
            } else {
            }
        });
    }


    function showHideButtons(){
        $(".btn-event-saved").hide();
    }

    function setTimer(){
        Swal.fire({
            icon: 'warning',
            title: 'Input number of minutes',
            input: 'number',
            inputAttributes: {
                step: 1
            },
            showCancelButton: true,
            confirmButtonText: 'Submit',
            showLoaderOnConfirm: true,
            preConfirm: (inputValue) => {
                inputValue = inputValue * 1;
                // Process the input value (e.g., send it to the server)
                return new Promise((resolve) => {
                setTimeout(() => {
                    if (Number.isInteger(inputValue)) {
                    // If the input is valid, resolve the promise
                    resolve();
                    } else {
                    // If the input is not valid, reject the promise with an error message
                    Swal.showValidationMessage('Invalid input');
                    }
                }, 1000);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("ajax/set_event_timer.php", {
                    event_id:event_id,
                    time:result.value
                }, function(data, status) {
                    if(data == 1){
                        success_update("Event Timer");
                    }
                });
            }
        });
    }
</script>
<?php include 'event_tabs/event_tabulation.php' ?>
<?php include 'event_tabs/event_criteria.php' ?>
<?php include 'event_tabs/event_judge.php' ?>
<?php include 'event_tabs/event_participant.php' ?>

