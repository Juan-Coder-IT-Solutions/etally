<script>
    $(document).ready(function(){
        renderTabulationData();
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
                var judge_points = "";
                for (let pIndex = 0; pIndex < tabElem.points.length; pIndex++) {
                    const point = tabElem.points[pIndex];
                    judge_points += `<td align="center">${(point > 0 ? point : "-")}</td>`;
                }
                tbody_tr += `<tr>
                    <td>${tabElem.participant_name}</td>
                    ${judge_points}
                    <td align="center">${tabElem.ranks}</td>
                    <td align="center">${tabElem.result > 0 ? tabElem.result : "-"}</td>
                </tr>`;
            }
            $("#tblTabulation tbody").html(tbody_tr);
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