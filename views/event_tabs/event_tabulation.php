<div class="modal fade" id="modalTieBreaker" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Resolve Tie Breaker</h5>
      </div>
      <div class="modal-body">
        <ul id="sortableList">
            <li class="draggable" data-id="1">Item 1</li>
            <li class="draggable" data-id="2">Item 2</li>
            <li class="draggable" data-id="3">Item 3</li>
            <li class="draggable" data-id="4">Item 4</li>
            <li class="draggable" data-id="5">Item 5</li>
        </ul>
        
  <button id="getOrderButton">Get Order</button>
  <div id="orderDisplay"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-outline-success" form="formCriteria" type="submit" id="btn_submit_tie_breaker">
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
  background-color: #3498db;
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
    $(document).ready(function(){
        renderTabulationData();

        $("#sortableList").sortable();
        $("#sortableList").disableSelection();

        $("#getOrderButton").click(function() {
            const order = $("#sortableList").sortable("toArray", { attribute: "data-id" });
            $("#orderDisplay").text("Order: " + order.join(", "));
        });
    });

    function renderTabulationData(){

        var params = `WHERE event_id = '${event_id}'`;
        var tbody_tr = '';
        $.post("ajax/get_event_tabulation.php",{
            params:params,
            event_id:event_id
        },function(data,status){
            var res = JSON.parse(data);
            console.log(res.data);
            skinTabulation(res.judges);
            for (let tabIndex = 0; tabIndex < res.data.length; tabIndex++) {
                const tabElem = res.data[tabIndex];
                var judge_points = "", champion = "",trophy = "";
                for (let pIndex = 0; pIndex < tabElem.points.length; pIndex++) {
                    const point = tabElem.points[pIndex];
                    judge_points += `<td align="center">${(point > 0 ? point : "-")}</td>`;
                }

                if(tabElem.result == 1){
                    champion = "class='champion'";
                    trophy = "<span class='fa fa-trophy trophy'></span>";
                }
                tbody_tr += `<tr ${champion}>
                    <td>${tabElem.participant_name} ${trophy}</td>
                    ${judge_points}
                    <td align="center">${tabElem.ranks}</td>
                    <td align="center">${tabElem.result > 0 ? tabElem.result : "-"}</td>
                </tr>`;
            }
            $("#tblTabulation tbody").html(tbody_tr);
            if(res.has_tie > 0){
                $("#tabulation_resolve").html(`<h1 class="h3 mb-0 text-gray-800">&nbsp;</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm" onclick="resolveTieBreakerModal()">
                    <i class="fas fa-check-circle fa-sm"></i> Resolve Tie Breakers
                </a>`);
            }
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

    function resolveTieBreakerModal(){
        $("#modalTieBreaker").modal('show');
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