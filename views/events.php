<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Events</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm" onclick="addModal()">
            <i class="fas fa-plus-circle fa-sm"></i> Add Record
        </a>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-left-success">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tblEntry" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Event</th>
                            <th>Participants</th>
                            <th>Judges</th>
                            <th>Event Start</th>
                            <th>Status</th>
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
<div class="modal fade" id="modalEntry" role="dialog">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add</h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-8 pdfviewer"></div>
          <div class="col-md-4">  
          <form class="forms-sample" id="formEntry" enctype="multipart/form-data">
            <input type="hidden" name="event_id" id="event_id" class="form-input">
            <div class="form-group">
              <label for="event_name">Event Name</label>
              <input type="text" class="form-control form-input" id="event_name" name="event_name" placeholder="Event Name"
                required>
            </div>
            <div class="form-group">
              <label for="event_description">Description</label>
              <input type="text" class="form-control form-input" id="event_description" name="event_description" placeholder="Event Description"
                required>
            </div>
            <div class="form-group">
              <label for="event_mechanics">Mechanics</label>
              <input class="form-control" type="file" name="event_mechanics" id="event_mechanics" accept=".pdf" onchange="previewPDF()" required />
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label for="participant_needed"># of Participants</label>
                <input type="number" min="0" class="form-control form-input" id="participant_needed" name="participant_needed" required>
              </div>
              <div class="form-group col-md-6">
                <label for="judge_needed"># of Judges</label>
                <input type="number" min="0" class="form-control form-input" id="judge_needed" name="judge_needed" required>
              </div>
            </div>
            <div class="form-group">
              <label for="event_start">Event Start</label>
              <input type="date" class="form-control form-input" id="event_start" name="event_start" required>
            </div>
          </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-outline-success" form="formEntry" type="submit" id="btn_submit">
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
  var table;
  var event_file_dir = "assets/img/mechanics/";
  $(document).ready(function() {
      renderData();

      $('#tblEntry tbody').on('click', '.btn-update-data', function() {
          var data = table.row($(this).closest('tr')).data();
          editModal(data);
          // You can access and use the data as needed
      });
  });

  function addModal() {
    // previewPDF(false);
    $(".modal-title").html("Add Entry");
    $("#modalEntry").modal('show');
    $('#formEntry')[0].reset();
    $(".pdfviewer").html(`<object id="preview" data="${event_file_dir}no_image.png" type="application/pdf" width="100%" style="min-height:450px;max-height: 450px;"><p>This browser does not support PDFs. Please download the PDF to view it: <a href="" id="downloadLink" target="_blank">Download PDF</a>.</p></object>`);
    $("#event_mechanics").prop("required",true);
  }

  function editModal(form_data) {
    $(".modal-title").html("Edit Entry");
    $('.form-input').each(function(index) {
      // 'this' refers to the current element in the loop
      var currentElement = $(this);
      var current_id = currentElement.attr('id');
      $(this).val(form_data[current_id]);
    });
    $(".pdfviewer").html(`<object id="preview" data="${event_file_dir+form_data.event_mechanics}" type="application/pdf" width="100%" style="min-height:450px;max-height: 450px;">
                <p>This browser does not support PDFs. Please download the PDF to view it: <a href="" id="downloadLink" target="_blank">Download PDF</a>.</p>
              </object>`);
              
    $("#event_mechanics").prop({"required":false}).val('');
    $("#modalEntry").modal('show');
  }

  function deleteEntry(event_id){
    Swal.fire({
        icon: 'question',
        title: 'Events',
        text: 'Are you sure to delete entry?',
        showCancelButton: true,
        allowOutsideClick: false
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          $.post("ajax/delete_event.php", {
              event_id:event_id
          }, function(data, status) {
            if(data == 1){
              success_add("Events");
            }
            renderData();
          });
        } else {
        }
      });
  }

  function viewEntry(event_id){
      window.location = "index.php?page=event-details&event_id="+event_id;
  }

  function renderData(){ 
    $('#tblEntry').DataTable().destroy();
    table = $("#tblEntry").DataTable({
        ajax: "ajax/get_events.php",
        columns: [
          { data: 'count' },
          { data: 'event_name' },
          {
            mRender: function(data, type, row) {
              return `${row.participants} / ${row.participant_needed}`;
            }
          },
          {
            mRender: function(data, type, row) {
              return `${row.judges} / ${row.judge_needed}`;
            }
          },
          { data: 'event_start' },
          {
            mRender: function(data, type, row) {
              return row.status == 'F' ? "Finished":(row.status == 'P'?"On Going":"Open for Registration");
            }
          },
          {
            mRender: function(data, type, row) {
              return `<button type="button" class="btn btn-success btn-rounded btn-icon btn-sm" onclick="viewEntry(${row.event_id})"><i class="fas fa-tasks"></i></button>
              <button type="button" class="btn btn-warning btn-rounded btn-icon btn-sm btn-update-data"><i class="fas fa-edit"></i></button>
              <button type="button" class="btn btn-danger btn-rounded btn-icon btn-sm" onclick="deleteEntry(${row.event_id})"><i class="fas fa-trash"></i></button>`;
            }
          },
        ]
      });
  }

  function viewMechanics(event_id){
    $("#uploadModal").modal('show');
  }

  function previewPDF() {
    const pdfInput = document.getElementById('event_mechanics');
    const preview = document.getElementById('preview');
    const downloadLink = document.getElementById('downloadLink');
    
    if (pdfInput.files.length > 0) {
      const file = pdfInput.files[0];
      const objectURL = URL.createObjectURL(file);
      
      preview.style.display = 'block';
      preview.data = objectURL;
      downloadLink.href = objectURL;
      downloadLink.innerText = `Download ${file.name}`;
    } else {
      preview.style.display = 'none';
    }
  }

  $("#formEntry").submit(function(e) {
      e.preventDefault();

      var formData = new FormData(this);
      $("#btn_submit").prop("disabled",true).html("<span class='fa fa-spin fa-spinner'></span> Loading");
      $.ajax({
        type: "POST",
        url: "ajax/add_event.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          if(response == 1){
            $("#event_id").val() > 0 ? success_update("Events"):  success_add("Events");
          }
          $("#modalEntry").modal('hide');
          renderData();
          $("#btn_submit").prop("disabled",false).html("<span class='fa fa-check-circle'></span> Submit");
        }
      });
  });
</script>