<div class="container-fluid">
    <!-- DataTales Example -->
    <div style="background-color: #ffc254;padding: 5px;border-radius: 6px;color: #fff;margin-bottom: 7px;">
        <h1 id="event_name"></h1>
        <p></p>
        <input type="hidden" id="event_id" value="<?=$_GET['event_id']?>">
    </div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#criteria">Criteria</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#participants">Participants</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#judges">Judges</a>
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
        <div class="tab-pane container" id="participants">
            <div class="row">
                <div class="card shadow mt-4 col border-left-success">
                    <div class="card-body">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">&nbsp;</h1>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm" onclick="addParticipantModal()">
                                <i class="fas fa-check-circle fa-sm"></i> Manage Event Participants
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tblParticipant" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Participant Name</th>
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
        <div class="tab-pane container" id="judges">
            <div class="row">
                <div class="card shadow mt-4 col border-left-success">
                    <div class="card-body">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">&nbsp;</h1>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm" onclick="addJudgeModal()">
                                <i class="fas fa-check-circle fa-sm"></i> Manage Event Judges
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tblJudge" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Judge #</th>
                                        <th>Judge Name</th>
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
    </div>
</div>
<script>
    var table_criteria,table_judges;
    var event_id = <?=$_GET['event_id']?>;
    $(document).ready(function(){
        getEventData();
        renderCriteriaData();
        renderJudgeData();
        renderParticipantData();
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
</script>
<?php include 'event_tabs/event_criteria.php' ?>
<?php include 'event_tabs/event_judge.php' ?>
<?php include 'event_tabs/event_participant.php' ?>

