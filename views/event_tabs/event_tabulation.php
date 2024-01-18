<div class="modal fade" id="modalTieBreaker" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Resolve Tie</h5>
      </div>
      <div class="modal-body">
        <input type="hidden" id="rank_result">
        <center><h5 id="modalTieBreaker_heading"></h5></center>
        <ul id="sortableList"></ul>
        <p>Note: drag participant to resolve tie.</p>
    </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-outline-success" type="button" id="btn_submit_tie_breaker" onclick="submitTieBreaker()">
            <span class="fa fa-check-circle"></span> Submit
        </button>
        <button class="btn btn-sm btn-outline-danger" data-dismiss="modal">
            <span class="fa fa-times-circle"></span> Close
        </button>
      </div>
    </div>
  </div>
</div>
<style>
#sortableList {
  list-style: none;
  padding: 0;
}

#sortableList>li {
  background-color: #1dc88a;
  color: #fff;
  text-align: center;
  line-height: 40px;
  margin: 5px;
  cursor: grab;
}

.dragging {
  cursor: grabbing;
}
</style>

<script>
    var results_data = [];
    var tie_scores = [];
    var tie_bg = ["warning","info","danger","error","success"];
    $(document).ready(function(){
        renderTabulationData();
        renderSelectJudgeData();
        renderTabulationJudgeData();

        $("#sortableList").sortable();
        $("#sortableList").disableSelection();
    });

    function renderSelectJudgeData(){
        var params = `WHERE event_id = '${event_id}'`;
        var option = '<option value="0"> &mdash; Please Select Judge &mdash; </option>';
        $.post("ajax/get_event_judges.php",{
            params:params
        },function(data,status){
            var res = JSON.parse(data);
            console.log(res.data);
            for (let judgeIndex = 0; judgeIndex < res.data.length; judgeIndex++) {
                const judgeElem = res.data[judgeIndex];
                option += `<option value='${judgeElem.judge_id}'>Judge ${judgeElem.judge_no}</option>`;
            }
            $("#judge_select").html(option);
        });
    }

    function renderTabulationJudgeData(){
        $.post("ajax/get_event_tabulation_per_judge.php",{
            event_id:event_id,
            judge_id:$("#judge_select").val()
        },function(data,status){
            var res = JSON.parse(data);
            skinJudgeTabulationHeader(res.criterias);
            skinJudgeTabulationBody(res.participants);
        });
    }

    function skinJudgeTabulationBody(participants){
        var tr = "";
        for (let pIndex = 0; pIndex < participants.length; pIndex++) {
            const participant = participants[pIndex];
            tr += `<tr>
                <td align="center">${participant.participant_name}</td>
                ${skinJudgeTabulationBodyScores(participant.scores)}
                <td align="center">${participant.rank}</td>
            </tr>`;
        }
        $("#tblJudgeTabulation tbody").html(tr);
    }

    function skinJudgeTabulationBodyScores(scores){
        var td = "";
        var total = 0;
        for (let cIndex = 0; cIndex < scores.length; cIndex++) {
            const score = scores[cIndex];
            if(score.is_normal == 1){
                td += `<td align="center" style="vertical-align: middle;">${score.criterias[0].score}</td>`;
                total += score.criterias[0].score;
            }else{
                var sub_total = 0;
                for (let ccIndex = 0; ccIndex < score.criterias.length; ccIndex++) {
                    const score_d = score.criterias[ccIndex];
                    sub_total += score_d.score;
                    td += `<td align="center" style="vertical-align: middle;">${score_d.score}</td>`;
                }
                td += `<td align="center" style="vertical-align: middle;">${sub_total}</td>`;
                total += sub_total;
            }
        }
        td += `<td align="center" style="vertical-align: middle;">${total}</td>`;
        return td;
    }

    function skinJudgeTabulationHeader(criterias){
        var th = "",th2 = "";
        for (let cIndex = 0; cIndex < criterias.length; cIndex++) {
            const cRow = criterias[cIndex];
            if(cRow.is_normal == 1){
                th += `<th rowspan="2" style="vertical-align: middle;">${cRow.criteria} &nbsp; ${cRow.points}%</th>`;
            }else{
                th += `<th colspan="${cRow.criterias.length+1}" style="vertical-align: middle;">${cRow.criteria} &nbsp; ${cRow.points}%</th>`;
                for (let ccIndex = 0; ccIndex < cRow.criterias.length; ccIndex++) {
                    const ccRow = cRow.criterias[ccIndex];
                    th2 += `<th style="vertical-align: middle;">${ccRow.criteria} &nbsp; ${ccRow.points}%</th>`;
                }
                th2 += `<th style="vertical-align: middle;">TOTAL</th>`;
            }
        }
        th += `<th rowspan="2" style="vertical-align: middle;">OVERALL</th>`;
        th += `<th rowspan="2" style="vertical-align: middle;">RESULT</th>`;
        $("#tblJudgeTabulation thead").html(`<tr>
            <th rowspan="2" style="vertical-align: middle;">CONTESTANT</th>
            ${th}
        </tr>
        <tr>${th2}</tr>`);
    }

    function renderTabulationData(){

        var params = `WHERE event_id = '${event_id}'`;
        var tbody_tr = '';
        results_data = [];
        tie_scores = [];
        $.post("ajax/get_event_tabulation.php",{
            params:params,
            event_id:event_id
        },function(data,status){
            var res = JSON.parse(data);
            console.log(res.data);
            skinTabulation(res.judges);
            for (let tabIndex = 0; tabIndex < res.data.length; tabIndex++) {
                const tabElem = res.data[tabIndex];
                var judge_points = "", champion = "",trophy = "",resolve="",tr_tie_class="";
                var rank_result = tabElem.result*1;
                results_data.push({
                    event_participant_id:tabElem.event_participant_id,
                    participant_name:tabElem.participant_name,
                    rank:rank_result
                });
                for (let pIndex = 0; pIndex < tabElem.points.length; pIndex++) {
                    const point = tabElem.points[pIndex];
                    judge_points += `<td align="center">${(point > 0 ? point : "-")}</td>`;
                }

                if(rank_result == 1){
                    champion = "champion";
                    trophy = "<span class='fa fa-trophy trophy'></span>";
                }

                if(!Number.isInteger(rank_result)){
                    if (!tie_scores.includes(rank_result)) {
                        tie_scores.push(rank_result);
                    }
                    let tie_index = tie_scores.indexOf(rank_result);
                    tr_tie_class = "text-white bg-" + tie_bg[tie_index];
                    // resolve = `<button class='btn btn-sm btn-outline-danger' style='float:right' onclick="resolveTieBreakerModal(${rank_result})"><i class="fas fa-check-circle fa-sm"></i> Resolve Tie</button>`;
                }

                tbody_tr += `<tr class='${champion} ${tr_tie_class}'>
                    <td>${tabElem.participant_name} ${trophy} ${resolve}</td>
                    ${judge_points}
                    <td align="center">${tabElem.ranks}</td>
                    <td align="center">${rank_result > 0 ? rank_result : "-"}</td>
                </tr>`;
            }
            $("#tblTabulation tbody").html(tbody_tr);

            $("#resolver").html('');
            for (let tIndex = 0; tIndex < tie_scores.length; tIndex++) {
                const tie_score = tie_scores[tIndex];
                $("#resolver").append(`<button class='btn btn-sm btn-outline-${tie_bg[tIndex]} mr-1'  onclick="resolveTieBreakerModal(${tie_score})"><i class="fas fa-check-circle fa-sm"></i> Resolve Tie (${tie_score})</button>`);
            }
            // if(res.has_tie > 0){
            //     $("#tabulation_resolve").html(`<h1 class="h3 mb-0 text-gray-800">&nbsp;</h1>
            //     <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm" onclick="resolveTieBreakerModal()">
            //         <i class="fas fa-check-circle fa-sm"></i> Resolve Tie Breakers
            //     </a>`);
            // }
        });
    }

    function skinTabulation(judges){
        var tr = "";
        for (let jIndex = 0; jIndex < judges.length; jIndex++) {
            // const jElem = judges[jIndex];
            tr += `<th>J${jIndex+1}</th>`;
        }
        var thead = `<tr>
            <th rowspan="2" style="vertical-align: middle;">CONTESTANT</th>
            <th colspan="${judges.length}">OVERALL</th>
            <th rowspan="2" style="vertical-align: middle;width:5%;">TOTAL OF RANKS</th>
            <th rowspan="2" style="vertical-align: middle;width:5%;">RESULT</th>
        </tr>
        <tr>${tr}</tr>`;
        $("#tblTabulation thead").html(thead);
    }

    function resolveTieBreakerModal(rank_result){
        $("#rank_result").val(rank_result);
        var sortableList = "",count_same_rank = 0;
        for (let resIndex = 0; resIndex < results_data.length; resIndex++) {
            const result = results_data[resIndex];
            if(result.rank == rank_result){
                sortableList += `<li class="draggable" data-id="${result.event_participant_id}">${result.participant_name}</li>`;
                count_same_rank++;
            }
        }
        var rank_floor = Math.floor(rank_result);
        var rank_last = rank_floor + count_same_rank - 1;
        $("#sortableList").html(sortableList);
        $("#modalTieBreaker_heading").html("Rank "+rank_floor+" - "+ rank_last);
        $("#modalTieBreaker").modal('show');
    }

    function submitTieBreaker(){
        var rank_result = $("#rank_result").val() * 1;
        $("#btn_submit_tie_breaker").prop("disabled",true).html("<span class='fa fa-spin fa-spinner'></span> Loading");
        const order = $("#sortableList").sortable("toArray", { attribute: "data-id" });
        $.post("ajax/resolve_tie_breaker.php", {
            event_id:event_id,
            rank_result:rank_result,
            rank_orders:order
        }, function(data, status) {
            $("#btn_submit_tie_breaker").prop("disabled",false).html("<span class='fa fa-check-circle'></span> Submit");
            if(data == 1){
                renderTabulationData();
                swal_success("Tie Breaker","Successfully resolve tie breaker");
                $("#modalTieBreaker").modal('hide');
            }
        });
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
</script>