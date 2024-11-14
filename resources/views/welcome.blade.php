<!-- resources/views/students/index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Student Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Student Management</h1>

    <!-- Add/Edit Student Modal -->
    <div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Add Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="studentForm">
                        <input type="hidden" id="student_id">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" required>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-success mb-2" id="createNewStudent">Add Student</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th width="150px">Action</th>
            </tr>
        </thead>
        <tbody id="studentsTable">
            @foreach ($students as $student)
            <tr id="student_{{ $student->id }}">
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->phone }}</td>
                <td>
                    <button data-id="{{ $student->id }}" class="btn btn-primary editBtn">Edit</button>
                    <button data-id="{{ $student->id }}" class="btn btn-danger deleteBtn">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // CSRF Token
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        // Open modal to add student
        $('#createNewStudent').click(function() {
            $('#studentForm').trigger("reset");
            $('#studentModalLabel').text("Add Student");
            $('#saveBtn').text("Save");
            $('#studentModal').modal('show');
        });

        // Edit student
        $('body').on('click', '.editBtn', function() {
            var id = $(this).data('id');
            $.get('/student/' + id, function(data) {
                $('#studentModalLabel').text("Edit Student");
                $('#saveBtn').text("Update");
                $('#student_id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#phone').val(data.phone);
                $('#studentModal').modal('show');
            });
        });

        // Delete student
        $('body').on('click', '.deleteBtn', function() {
            var id = $(this).data('id');
            if (confirm("Are you sure want to delete?")) {
                $.ajax({
                    type: "DELETE",
                    url: "/student/" + id,
                    success: function() { location.reload(); }
                });
            }
        });
    });
</script>
</body>
</html>
