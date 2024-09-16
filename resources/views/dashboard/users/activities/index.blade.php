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
                                    @include('dashboard.alerts.alert')
                                    <h4 class="title">Activities ({{ count($activities) }})</h4>
                                    <!-- Button to open modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#createActivity">
                                        Add New Activity
                                    </button>
                                </div>
                                <div style="padding: 30px" class="content table-responsive table-full-width">
                                    <table id="activitiesTable" class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Description</th>
                                                <th>Updates</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($activities as $activity)
                                                <tr>
                                                    <td>{{ $activity->id }}</td>
                                                    <td>{{ $activity->description }}</td>
                                                    <td> {{ $activity->updates->count() }} </td>
                                                    <td>{{ $activity->createdByUser ? $activity->createdByUser->name : 'N/A' }}
                                                    </td>
                                                    <td>{{ $activity->created_at }}</td>

                                                    <td>
                                                        <a href="#" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#changeActivityStatus"
                                                            data-id="{{ $activity->id }}"
                                                            onclick="changeActivityStatus({{ json_encode($activity) }})"
                                                            data-description="{{ $activity->description }}">
                                                            Change Status
                                                        </a>

                                                         <a href="{{ route('users.dashboard.activity.show', $activity->id) }}"
                                                            class="btn btn-primary">View</a>

                                                    </td>

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

        <div class="modal fade" id="createActivity" tabindex="-1" role="dialog" aria-labelledby="activityModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activityModalLabel">Add New Activity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.dashboard.activity.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="description">Activity Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
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

    <div class="modal fade" id="changeActivityStatus" tabindex="-1" role="dialog"
        aria-labelledby="changeActivityStatusLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeActivityStatusLabel">Change Activity Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.dashboard.activity.update.status') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="description">Activity</label>
                            <input type="text" readonly class="form-control" id="description" name="description">
                        </div>

                        <div class="form-group">
                            <label for="activity_id">Activity ID</label>
                            <input type="text" readonly class="form-control" id="activity_id" name="activity_id">
                        </div>

                        <div class="form-group">
                            <label for="remark">Remark</label>
                            <textarea class="form-control" id="remark" name="remark" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending">Pending</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('dashboard.admins.includes.script')

</body>


<script>
     function changeActivityStatus(data) {

        document.getElementById('description').value = '';
        document.getElementById('activity_id').value = '';

        // Populate the form with the new data
        document.getElementById('description').value = data.description;
        document.getElementById('activity_id').value = data.id;
    }
</script>




</html>
