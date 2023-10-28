<div class="modal fade" id="modalParticipant" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add</h5>
      </div>
      <div class="modal-body">
        <form class="forms-sample" id="formParticipant">
            <input type="hidden" name="event_id" id="participant_event_id" class="form-input">
            <input type="hidden" name="event_participant_id" id="event_participant_id" class="form-input">
          <div class="form-group">
            <label for="participant_ids">participant Name</label>
            <select name="participant_ids[]" id="participant_ids" class="form-control" multiple="multiple" style="width: 100%;">
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-outline-success" form="formParticipant" type="submit" id="btn_submit_participant">
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
    var participant_ids = [];
    $(document).ready(function(){

        $('#tblParticipant tbody').on('click', '.btn-update-participant-data', function() {
            var data = table_participant.row($(this).closest('tr')).data();
            editParticipantModal(data);
            // You can access and use the data as needed
        });
    });

    function renderParticipantData(){

        var params = `WHERE event_id = '${event_id}'`;
        var tbody_tr = '';
        participant_ids = [];
        $.post("ajax/get_event_participants.php",{
            params:params
        },function(data,status){
            var res = JSON.parse(data);
            console.log(res.data);
            for (let participantIndex = 0; participantIndex < res.data.length; participantIndex++) {
                const participantElem = res.data[participantIndex];
                participant_ids.push(participantElem.participant_id);
                tbody_tr += `<tr>
                    <td>${participantIndex+1}</td>
                    <td>${participantElem.participants.participant_name}</td>
                    <td>${participantElem.participants.participant_year}</td>
                    <td>${participantElem.program_name}</td>
                    <td><img class="img-profile img-rounded" src="assets/img/profiles/${participantElem.participants.participant_img}" alt="Image" style="width: 100px;"></td>
                </tr>`;
            }
            $("#tblParticipant tbody").html(tbody_tr);
        });


        // $('#tblParticipant').DataTable().destroy();
        // table_participant = $("#tblParticipant").DataTable({
        //     ajax: "ajax/get_event_participants.php",
        //     searching:false,
        //     sorting:false,
        //     paging:false,
        //     bInfo:false,
        //     columns: [
        //         { data: 'event_participant_id' },
        //         { data: 'participant_name' },
        //         {
        //             mRender: function(data, type, row) {
        //                 return `<button type="button" class="btn btn-warning btn-rounded btn-icon btn-sm btn-update-participant-data"><i class="fas fa-edit"></i></button>
        //                 <button type="button" class="btn btn-danger btn-rounded btn-icon btn-sm" onclick="deleteparticipantEntry(${row.event_participant_id})"><i class="fas fa-trash"></i></button>`;
        //             }
        //         },
        //     ]
        // });
    }
    function addParticipantModal(){
        $(".modal-title").html("Add Entry");
        $("#modalParticipant").modal('show');
        $('#formParticipant')[0].reset();
        $("#participant_event_id").val(event_id);
        get_participants();
    }

    function get_participants()
    {
        var option_participant = "<option value=''> &mdash; Please Select &mdash; </option>";
        $.post("ajax/get_participants.php",{},function(data,status){
            var res = JSON.parse(data);
            for (let participantIndex = 0; participantIndex < res.data.length; participantIndex++) {
                const participantElem = res.data[participantIndex];
                var selected = participant_ids.includes(participantElem.participant_id) ? "selected" : "";
                option_participant += `<option value='${participantElem.participant_id}' ${selected}> ${participantElem.participant_name} </option>`;
            }
            $("#participant_ids").html(option_participant).select2();
        });
    }

    function editParticipantModal(form_data) {
        $(".modal-title").html("Edit Entry");
        $('#formParticipant .form-input').each(function(index) {
            // 'this' refers to the current element in the loop
            var currentElement = $(this);
            var current_id = currentElement.attr('id');
            $(this).val(form_data[current_id]);
        });
        $("#participant_event_id").val(event_id);
        $("#modalParticipant").modal('show');
    }

    $("#formParticipant").submit(function(e) {
        e.preventDefault();
        var form_data = $(this).serialize();
        console.log(form_data);
        $("#btn_submit_participant").prop("disabled",true).html("<span class='fa fa-spin fa-spinner'></span> Loading");
        $.post("ajax/add_event_participants.php", form_data, function(data, status) {
            if(data == 1){
                success_update("Event participants");
            }
            $("#modalParticipant").modal('hide');
            renderParticipantData();
            $("#btn_submit_participant").prop("disabled",false).html("<span class='fa fa-check-circle'></span> Submit");
        });
    });

    function deleteparticipantEntry(event_participant_id){
        Swal.fire({
            icon: 'question',
            title: 'Event participants',
            text: 'Are you sure to delete entry?',
            showCancelButton: true,
            allowOutsideClick: false
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.post("ajax/delete_event_participant.php", {
                    event_participant_id:event_participant_id
                }, function(data, status) {
                    if(data == 1){
                        success_delete("participant");
                    }
                    renderParticipantData();
                });
            } else {
            }
        });
    }
</script>