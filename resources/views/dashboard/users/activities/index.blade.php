<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Activities Tracker | Dashboard</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    @include('dashboard.admins.includes.head')

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        /* Custom Styles for DataTables */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0;
        }
    </style>
</head>

<body>

    <div class="wrapper">

        @include('dashboard.users.includes.sidebar')
        <div class="main-panel">
            @include('dashboard.users.includes.topnav')
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                       <h4 class="title">Your Updates</h4>
                        <p class="category">Reports on Activities You Updated</p>
                                    <!-- Button to open modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#activityModal">
                                        Add New Activity
                                    </button>
                                </div>
                                <div class="content table-responsive table-full-width">
                                    <table id="activitiesTable" class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Activity Description</th>
                                                <th>Status</th>
                                                <th>Remark</th>
                                                <th>Personnel</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($updates as $update)
                                                <tr>
                                                    <td>{{ $update->id }}</td>
                                                    <td>{{ $update->activity->description }}</td>
                                                    <td
                                                        style="color: {{ $update->status === 'done' ? 'green' : 'black' }}">
                                                        {{ Str::ucfirst($update->status) }}</td>
                                                    <td>{{ $update->remark }}</td>
                                                    <td>{{ $update->user->name }}</td>
                                                    <td>{{ $update->manual_updated_at }}</td>

                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>

            @include('dashboard.admins.includes.footer')

        </div>
    </div>

    <!-- Modal for adding a new activity -->
    <div class="modal fade" id="activityModal" tabindex="-1" role="dialog" aria-labelledby="activityModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activityModalLabel">Add New Activity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.dashboard.activity.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="description">Activity Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending">Pending</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="remark">Remark</label>
                            <textarea class="form-control" id="remark" name="remark" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="personnel">Personnel</label>
                            <input type="text" class="form-control" id="personnel" name="personnel" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Activity</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('dashboard.admins.includes.script')

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#activitiesTable').DataTable();
        });


        $('#saveActivityButton').click(function() {
            $.ajax({
                url: {{ route('users.dashboard.activity.store') }}, // Adjust this URL to your route
                method: 'POST',
                data: {
                    activity_id: $('#activity_id').val(),
                    user_id: $('#user_id').val(),
                    status: $('#status').val(),
                    remark: $('#remark').val(),
                    manual_updated_at: $('#manual_updated_at').val(),
                    createdBy: $('#createdBy').val(),
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                },
                success: function(response) {
                    alert(response.message);
                    $('#updateModal').modal('hide'); // Close the modal
                    location.reload(); // Optionally reload the page
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });
    </script>
</body>

</html>
