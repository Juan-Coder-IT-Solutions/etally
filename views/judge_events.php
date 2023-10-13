<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Events</h1>
</div>

<div class="row">
    <div class="col-lg-12 events">
    </div>
</div>
<script>
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
        var criterias_tr = "";
        for (let criIndex = 0; criIndex < eventElem.criterias.length; criIndex++) {
          const criElem = eventElem.criterias[criIndex];
          criterias_tr += `<tr><td>${criElem.criteria}</td><td>${criElem.points}</td></tr>`;
        }
        events += `<div class="card shadow mb-4">
            <a href="#eventCollapse${eventIndex}" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="eventCollapse${eventIndex}">
                <h6 class="m-0 font-weight-bold text-primary">${eventElem.event_name+" - "+eventElem.event_description}</h6>
            </a>
            <div class="collapse" id="eventCollapse${eventIndex}">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <iframe src="assets/img/mechanics/${eventElem.event_mechanics}" width="100%" height="500" frameborder="0"></iframe>
                    </div>
                    <div class="col-md-4">
                      <h6>Criteria</h6>
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>Criteria</th>
                            <th>Points</th>
                          </tr>
                        </thead>
                        <tbody>${criterias_tr}</tbody>
                      </table>
                      <button class="btn btn-primary">Evaluate Now</button>
                    </div>
                  </div>
                </div>
            </div>
        </div>`;
      }
      $(".events").html(events);
    });

  }
</script>