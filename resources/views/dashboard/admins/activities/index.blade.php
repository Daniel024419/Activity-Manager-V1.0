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

        /* Example CSS for Modal */
        .modal {
            z-index: 1050;
            /* Ensure modal is above the backdrop */
        }

        .modal-backdrop {
            z-index: 1040;
            /* Backdrop should be below the modal */
        }
    </style>
</head>

<body>

    <div class="wrapper">

        @include('dashboard.admins.includes.sidebar')
        <div class="main-panel">
            @include('dashboard.admins.includes.topnav')
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Generate Filter</h4>
                                    <p class="category">Filter activities by date range</p>
                                </div>
                                <div class="content">
                                    <form method="GET" enctype="multipart/form-data"
                                        action="{{ route('admin.activity.dashboard.filter') }}" class="form-inline">

                                        @csrf
                                        <div class="form-group">
                                            <label for="startDate" class="sr-only">Start Date</label>
                                            <input type="date" class="form-control" id="startDate" name="start_date"
                                                required>
                                        </div>
                                        <div class="form-group mx-sm-3">
                                            <label for="endDate" class="sr-only">End Date</label>
                                            <input type="date" class="form-control" id="endDate" name="end_date"
                                                required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Generate</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    @include('dashboard.alerts.alert')
                                    <h4 class="title">Activities ( {{ count($activities) }} ) </h4>
                                    <p class="category">Daily Updates and Remarks</p>
                                    <!-- Button to open modal -->

                                    <span>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#activityModal">
                                            Add New Activity
                                        </button>

                                        {{-- <a href="{{ route('admin.activity.dashboard.download') }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-download"></i> Download Activities
                                        </a> --}}
                                    </span>

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
                                                        <a href="{{ route('admin.activity.dashboard.destroy', $activity->id) }}"
                                                            onclick="return confirmDelete(event);"
                                                            class="btn btn-danger">Delete</a>
                                                        <a href="{{ route('admin.activity.dashboard.show', $activity->id) }}"
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

    @include('dashboard.admins.includes.script')
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
                <form action="{{ route('admin.activity.dashboard.store') }}" method="POST"
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
</body>

</html>
