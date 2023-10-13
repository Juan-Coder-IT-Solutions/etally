<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Judges</h1>
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
                        <th></th>
                        <th>Name</th>
                        <th>Affiliation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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
                  <input type="hidden" name="judge_id" id="judge_id" class="form-input">
                <div class="form-group">
                  <label for="judge_name">Judge Name</label>
                  <input type="text" class="form-control form-input" id="judge_name" name="judge_name" placeholder="Account Name"
                    required>
                </div>
                <div class="form-group">
                  <label for="judge_qualification">Qualification</label>
                  <input class="form-control" type="file" name="judge_qualification" id="judge_qualification" accept=".pdf" onchange="previewPDF()" required />
                </div>
                <div class="form-group">
                  <label for="judge_affiliation">Affiliation</label>
                  <textarea class="form-control form-input" id="judge_affiliation" name="judge_affiliation" placeholder="Affiliation" required></textarea>
                </div>
                <div class="form-group form-hide-group">
                  <label for="username">Username</label>
                  <input type="text" class="form-control form-hide" id="username" name="username" placeholder="Username"
                    required>
                </div>
                <div class="form-group form-hide-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control form-hide" id="password" name="password" placeholder="Password"
                    required>
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
  var quali_file_dir = "assets/img/qualifications/";
$(document).ready(function() {
    renderData();

    $('#tblEntry tbody').on('click', '.btn-update-data', function() {
        var data = table.row($(this).closest('tr')).data();
        editModal(data);
        // You can access and use the data as needed
    });
});

function addModal() {
  $(".modal-title").html("Add Entry");
  $("#modalEntry").modal('show');
  $('#formEntry')[0].reset();
  $(".pdfviewer").html(`<object id="preview" data="${quali_file_dir}no_image.png" type="application/pdf" width="100%" style="min-height:450px;max-height: 450px;"><p>This browser does not support PDFs. Please download the PDF to view it: <a href="" id="downloadLink" target="_blank">Download PDF</a>.</p></object>`);
  $(".form-hide-group").show();
  $(".form-hide").prop("required",true);
}

function editModal(form_data) {
  $(".modal-title").html("Edit Entry");
  $('.form-input').each(function(index) {
    // 'this' refers to the current element in the loop
    var currentElement = $(this);
    var current_id = currentElement.attr('id');
    $(this).val(form_data[current_id]);
  });
  $(".pdfviewer").html(`<object id="preview" data="${quali_file_dir+form_data.judge_qualification}" type="application/pdf" width="100%" style="min-height:450px;max-height: 450px;"><p>This browser does not support PDFs. Please download the PDF to view it: <a href="" id="downloadLink" target="_blank">Download PDF</a>.</p></object>`);
  $(".form-hide-group").hide();
  $(".form-hide").prop("required",false);
  $("#judge_qualification").prop({"required":false}).val('');
  $("#modalEntry").modal('show');
}

function deleteEntry(judge_id){
  Swal.fire({
			icon: 'question',
			title: 'Judges',
			text: 'Are you sure to delete entry?',
			showCancelButton: true,
			allowOutsideClick: false
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
        $.post("ajax/delete_judge.php", {
            judge_id:judge_id
        }, function(data, status) {
          if(data == 1){
            success_add("Judges");
          }
          renderData();
        });
			} else {
			}
		});

}

function renderData(){ 
  $('#tblEntry').DataTable().destroy();
  table = $("#tblEntry").DataTable({
      ajax: "ajax/get_judges.php",
      columns: [
        { data: 'count' },
        { 
            mRender:function(data,type,row){
                return `<img class="img-rounded" src="assets/img/undraw_profile.svg" alt="Image" style="width: 30px;">`;
            }
         },
        { data: 'judge_name' },
        { data: 'judge_affiliation' },
        {
          mRender: function(data, type, row) {
            return `<button type="button" class="btn btn-warning btn-rounded btn-icon btn-sm btn-update-data"><i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-danger btn-rounded btn-icon btn-sm" onclick="deleteEntry(${row.judge_id})"><i class="fas fa-trash"></i></button>`;
          }
        },
      ]
    });
}

function previewPDF() {
    const pdfInput = document.getElementById('judge_qualification');
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
      url: "ajax/add_judge.php",
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        if(response == 1){
          $("#judge_id").val() > 0 ? success_update("Judges"):  success_add("Judges");
        }else if(response == 2){
          swal_error("Judge","Username already exist.");
        }else{

        }
        $("#modalEntry").modal('hide');
        renderData();
        $("#btn_submit").prop("disabled",false).html("<span class='fa fa-check-circle'></span> Submit");
      }
    });
});
</script>