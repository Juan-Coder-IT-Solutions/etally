<div class="row">
  <div class="col-sm-12 mb-4 mb-xl-0">
    <h4 class="font-weight-bold text-dark">User Management</h4>
    <p class="font-weight-normal mb-2 text-muted">Manage users here.</p>
  </div>
  <div class="col-sm-12 mb-5 mb-xl-0">
    <button class="btn btn-rounded btn-primary" onclick="addUserModal()">Add</button>
  </div>
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover" id="tbl_user">
            <thead>
              <tr>
                <th></th>
                <th>#</th>
                <th>Account Name</th>
                <th>Username</th>
                <th>Category</th>
                <th>Status</th>
                <th></th>
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
<div class="modal fade" id="userModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Add</h5>
      </div>
      <div class="modal-body">
        <form class="forms-sample" id="userForm">
          <div class="form-group">
            <label for="account_name">Account Name</label>
            <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Account Name"
              required>
          </div>
          <div class="form-group">
            <label for="user_category">Category</label>
            <select class="form-control" id="user_category" name="user_category" required>
              <option value="">&mdash; Please Select &mdash;</option>
              <option value="A"> Administrator </option>
              <option value="U"> User </option>
            </select>
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" form="userForm" type="submit">Submit</button>
        <button class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  var isEdit = false;
  $(document).ready(function() {
    renderUser();
  });
  function renderUser() {
    $("#tbl_user").DataTable().destroy();
    $("#tbl_user").DataTable({
      ajax: "ajax/get_user.php",
      columns: [
        {
          mRender: function(data, type, row) {
            return `<input type="checkbox" value="${row.user_id}">`;
          }
        },
        { data: 'user_id' },
        { data: 'account_name' },
        { data: 'username' },
        { data: 'user_category' },
        { data: 'user_category' },
        {
          mRender: function(data, type, row) {
            return `<div class="flex flex2">
              <button type="button" class="btn btn-primary btn-rounded btn-icon btn-sm flex-items"><i class="mdi mdi-pencil-outline"></i></button>
              <button type="button" class="btn btn-danger btn-rounded btn-icon btn-sm flex-items"><i class="mdi mdi-delete-outline"></i></button>
            </div>`;
          }
        },
      ]
    });
  }

  function addUserModal() {
    $("#userModal").modal('show');
  }

  $("#userForm").submit(function(e) {
    e.preventDefault();
    var form_data = $(this).serialize();
    console.log(form_data);
    $.post("ajax/add_user.php", form_data, function(data, status) {
      $("#userModal").modal('hide');
      renderUser();
    });
  });
</script>
<style>
  .flex {
    display: flex;
  }

  .flex2 {
    justify-content: space-around;
  }

  .flex3 {
    justify-content: space-between;
  }

  .flex-items {
    text-align: center;
  }
</style>