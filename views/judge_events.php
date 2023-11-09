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
        var btn_evaluate = eventElem.event_status == "P" ? "" : "disabled";
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
                      <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm btn-event-saved" onclick="rateParticipants(${eventElem.event_id},${res.judge_id})" ${btn_evaluate}>
                          <i class="fas fa-check-circle fa-sm"></i> Evaluate Now
                      </button>
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

        var criteria_index = 0;

        for (let cmIndex = 0; cmIndex < pRow.main_criterias.length; cmIndex++) {
          const cmRow = pRow.main_criterias[cmIndex];
          var hide_main = cmRow.is_normal == 1 ? "style='display:none;'" : "";
          pc_tbody += `<tr data-participant-id="${pIndex}" data-main-criteria-id="${cmIndex}" ${hide_main}>
            <th style="padding:5px;">${cmIndex+1}</th>
            <th style="padding:5px;" colspan="2">${cmRow.criteria}</th>
            <th style="padding:5px;">
              <div class="range-container">
                  <input type="number" value="${cmRow.score * 1}" class="form-control" id="pmc-${pIndex}-${cmIndex}" readonly>
                  <span class="range-value">/</span>
                  <span class="range-value">${cmRow.points * 1}</span>
                </div>
            </th>
          </tr>`;
          for (let cIndex = 0; cIndex < cmRow.criterias.length; cIndex++) {
            const pcRow = cmRow.criterias[cIndex];
            var form_criterias = {
              criteria_id:pcRow.criteria_id,
              score:pcRow.score
            };

            form_participants.criterias.push(form_criterias);
            if(cmRow.is_normal == 1){
              pc_tbody += `<tr data-participant-id="${pIndex}" data-criteria-id="${criteria_index}" data-main-criteria-id="${cmIndex}">
                <th style="padding:5px;">${cmIndex+1}</th>
                <th style="padding:5px;" colspan="2">${cmRow.criteria.replace(/\n/g, "<br>")}</th>
                <th style="padding:5px;">
                  <div class="range-container">
                    <input type="number" min="0" max="${pcRow.points * 1}" value="${pcRow.score * 1}" class="form-control pc-${pIndex} pmc-${pIndex}-${cmIndex}" onchange="evaluateParticipant(this)">
                      <span class="range-value">/</span>
                      <span class="range-value" id="pc-${pIndex}-${criteria_index}-${cmIndex}">${pcRow.points * 1}</span>
                    </div>
                </th>
              </tr>`;
            }else{
              pc_tbody += `<tr data-participant-id="${pIndex}" data-criteria-id="${criteria_index}" data-main-criteria-id="${cmIndex}">
                <td style="padding:5px;"></td>
                <td style="padding:5px;"></td>
                <td style="padding:5px;">${pcRow.criteria.replace(/\n/g, "<br>")}</td>
                <td style="padding:5px;">
                  <div class="range-container">
                    <input type="number" min="0" max="${pcRow.points * 1}" value="${pcRow.score * 1}" class="form-control pc-${pIndex} pmc-${pIndex}-${cmIndex}" onchange="evaluateParticipant(this)">
                    <span class="range-value">/</span>
                    <span class="range-value" id="pc-${pIndex}-${criteria_index}-${cmIndex}">${pcRow.points * 1}</span>
                  </div>
                </td>
              </tr>`;
            }
            criteria_index++;
          }
        }

        form_evaluation.push(form_participants);

        modalRateParticipants_body += `
        <div class="col-md-6">
          <div class="card shadow h-100 py-2">
              <div class="card-body">
                  <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <img class="img-account-profile rounded-circle" src="assets/img/profiles/${pRow.participant.participant_img}" alt="Image" style="width: 100px;height: 100px;">
                      </div>
                      <div class="col-auto">
                      <div class="text-lg font-weight-bold text-success text-uppercase mb-1">${pRow.participant_name}</div>
                      <div class="font-weight-bold text-primary text-uppercase mb-1">${pRow.participant.participant_year}</div>
                      <div class="text-xxl font-weight-bold text-warning text-uppercase mb-1">${pRow.participant.program_name}</div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
        <table class="table table-bordered mt-2 mb-5">
          <thead>
            <tr>
              <th colspan="4">${pRow.participant_name}</th>
            </tr>
            <tr>
              <th style="width:5%;">#</th>
              <th colspan="2">Criteria</th>
              <th style="width:25%;">Score</th>
            </tr>
          </thead>
          <tbody>${pc_tbody}</tbody>
          <tfooter>
            <tr>
              <th style="text-align:right;" colspan="3">Total Points</th>
              <th id="participant-${pIndex}">${pRow.score*1}</th>
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
    var main_criteria_id = tr_element.getAttribute("data-main-criteria-id");

    // alert(ele.value);
    form_evaluation[participant_id].criterias[criteria_id].score = ele.value * 1;
    // $("#pc-"+participant_id+"-"+criteria_id+"-"+main_criteria_id).html(ele.value);
  
    const pc_class = document.querySelectorAll(".pc-"+participant_id);
    const pmc_class = document.querySelectorAll(".pmc-"+participant_id+"-"+main_criteria_id);

    let pc_sum = sumWithClass(pc_class);
    let pmc_sum = sumWithClass(pmc_class);
    $("#participant-"+participant_id).html(pc_sum);
    $("#pmc-"+participant_id+"-"+main_criteria_id).val(pmc_sum);
  }

  function sumWithClass(element_class){
    let sum = 0;
    element_class.forEach((element) => {
      sum += parseFloat(element.value);
    });
    return sum;
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