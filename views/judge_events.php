<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Events</h1>
</div>

<div class="row">
    <div class="col-lg-12 events">
    </div>
</div>

<div class="modal fade" id="modalRateParticipants" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalRateParticipants_title">Evaluate Participants</h5>
      </div>
      <div class="modal-body" id="modalRateParticipants_body" style="max-height: 450px;overflow:auto;">
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-outline-success" type="button" id="btn_submit_evaluation" onclick="submitEvaluation()">
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
  var form_evaluation = [];
  $(document).ready(function(){
    getJudgeEvents();
  });

  function getJudgeEvents(){
    $.post("ajax/get_judge_events.php",{
    },function(data,status){
      var res = JSON.parse(data);
      var events = "";
      for (let eventIndex = 0; eventIndex < res.data.length; eventIndex++) {
        const eventElem = res.data[eventIndex];
        var participants_tr = "";
        for (let pIndex = 0; pIndex < eventElem.participants.length; pIndex++) {
          const pElem = eventElem.participants[pIndex];
          participants_tr += `<tr>
            <td>${pElem.participant_name}</td>
            <td>${pElem.scores > 0 ? pElem.scores:"-"}</td>
            <td>${pElem.rank > 0 ? pElem.rank:"-"}</td>
          </tr>`;
        }
        events += `<div class="card shadow mb-4">
            <a href="#eventCollapse${eventIndex}" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="eventCollapse${eventIndex}">
                <h6 class="m-0 font-weight-bold text-primary">${eventElem.event_name+" - "+eventElem.event_description}</h6>
            </a>
            <div class="collapse" id="eventCollapse${eventIndex}">
                <div class="card-body">
                  <div class="d-sm-flex align-items-center justify-content-between mb-4">
                      <h1 class="h3 mb-0 text-gray-800">&nbsp;</h1>
                      <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm btn-event-saved" onclick="rateParticipants(${eventElem.event_id},${res.judge_id})">
                          <i class="fas fa-check-circle fa-sm"></i> Evaluate Now
                      </a>
                  </div>
                  <div class="row">
                    <div class="col-md-8">
                      <iframe src="assets/img/mechanics/${eventElem.event_mechanics}" width="100%" height="500" frameborder="0"></iframe>
                    </div>
                    <div class="col-md-4">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>Participants</th>
                            <th>Score</th>
                            <th>Rank</th>
                          </tr>
                        </thead>
                        <tbody>${participants_tr}</tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
        </div>`;
      }
      $(".events").html(events);
    });

  }

  function rateParticipants(event_id,judge_id){
    form_evaluation = [];
    $("#modalRateParticipants").modal('show');
    $.post("ajax/get_judge_events_for_evaluation.php",{
      event_id:event_id
    },function(data,status){
      var res = JSON.parse(data);

      var modalRateParticipants_body = `<input type='hidden' value="${event_id}" id="event_id">
      <input type='hidden' value="${judge_id}" id="judge_id">`;

      for (let pIndex = 0; pIndex < res.participants.length; pIndex++) {
        const pRow = res.participants[pIndex];

        var pc_tbody = "";
        var form_participants = {
          participant_id:pRow.participant_id,
          criterias:[]
        };
        for (let cIndex = 0; cIndex < pRow.criterias.length; cIndex++) {
          const pcRow = pRow.criterias[cIndex];
          var form_criterias = {
            criteria_id:pcRow.criteria_id,
            score:0
          };

          form_participants.criterias.push(form_criterias);

          pc_tbody += `<tr data-participant-id="${pIndex}" data-criteria-id="${cIndex}">
              <td>`+pcRow.criteria+`</td>
              <td>
              <div class="range-container">
                <input type="range" min="0" max="${pcRow.points * 1}" value="0" class="form-control pc-${pIndex}" onchange="evaluateParticipant(this)">
                <span class="range-value" id="pc-${pIndex}-${cIndex}">0</span>
              </td>
            </tr>`;
        }

        form_evaluation.push(form_participants);

        modalRateParticipants_body += `<table class="table table-bordered mt-2">
          <thead>
            <tr>
              <th colspan="2">${pRow.participant_name}</th>
            </tr>
            <tr>
              <th>Criteria</th>
              <th>Points</th>
            </tr>
          </thead>
          <tbody>${pc_tbody}</tbody>
          <tfooter>
            <tr>
              <th style="text-align:right;">Total Points</th>
              <th id="participant-${pIndex}">0</th>
            </tr>
          </tfooter>
        </table>`;
      }
      $("#modalRateParticipants_body").html(modalRateParticipants_body);
    });
  }

  function evaluateParticipant(ele)
  {
    var tr_element = ele.parentNode.parentNode.parentNode;
    var participant_id = tr_element.getAttribute("data-participant-id");
    var criteria_id = tr_element.getAttribute("data-criteria-id");

    // alert(ele.value);
    form_evaluation[participant_id].criterias[criteria_id].score = ele.value * 1;
    $("#pc-"+participant_id+"-"+criteria_id).html(ele.value);
  
    const elementsWithClass = document.querySelectorAll(".pc-"+participant_id);

    let sum = 0;
    elementsWithClass.forEach((element) => {
      sum += parseFloat(element.value);
    });

    $("#participant-"+participant_id).html(sum);
  }

  function submitEvaluation(){
    var event_id = $("#event_id").val();
    var judge_id = $("#judge_id").val();
    $.post("ajax/add_event_scores.php",{
      event_id:event_id,
      judge_id:judge_id,
      scores:form_evaluation
    },function(data,status){
      $("#modalRateParticipants").modal('hide');
      if(data == 1){
        success_add("Evaluation");
        getJudgeEvents();
      }
    });
  }
</script>
<style>
  .range-container {
      display: flex;
      align-items: center;
  }
  .range-value {
      margin-left: 10px;
  }
</style>