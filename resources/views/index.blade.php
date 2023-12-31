<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- for data table --}}
    <script src="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <title>Document</title>
</head>
<body>
<div class="container">
    <h2>Ajax Laravel CRUD Datatable</h2>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{$message}}</p>
        </div>
    @endif
    <a href="#" class="btn btn-primary" onclick="add()" href="javascript:void(0)">Create Employee</a>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{$message}}</p>
        </div>
    @endif
    <table class="table table-bordered" id="ajax-crud-datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Created at</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

<!-- Modal -->
<div class="modal fade" id="employee-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Employee</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- form start --}}
          <form action="javascript:void(0)" id="EmployeeForm" method="POST" name="EmployeeForm" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" >
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address">
              </div>
            <button type="submit" class="btn btn-primary" id="btn-save">Save Changes</button>
          </form>
          {{-- form end --}}
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#ajax-crud-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{url('crud')}}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name',name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'address', name: 'address'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action',orderable:false},
        ],
        order: [[0,'desc']]
    });
});
function add(){
    $('#EmployeeForm').trigger("reset");
    $('#EmployeeModal').html("Add Employee");
    $('#employee-modal').modal('show');
    $('#id').val('');
}
$('#EmployeeForm').submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type:'POST',
        url: "{{ url('store') }}",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
            console.log(data);
            $('#employee-modal').modal('hide');
            $('#btn-save').html('Submit');
            $('#btn-save').attr("disabled",false);
        },
        error: function(data){console.log(data);}
    });
});
</script>
</body>
</html>
