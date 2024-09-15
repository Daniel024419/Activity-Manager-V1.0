<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Activities Report | Dashboard</title>

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

        @include('dashboard.admins.includes.sidebar')
        <div class="main-panel">
            @include('dashboard.admins.includes.topnav')
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Activities Report</h4>
                                    <p class="category">From {{ $startDate->format('d/m/Y') }} to {{ $endDate->format('d/m/Y') }}</p>
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
                                            @foreach ($activities as $activity)
                                                @foreach ($activity->updates as $update)
                                                    <tr>
                                                        <td>{{ $update->id }}</td>
                                                        <td>{{ $activity->description }}</td>
                                                        <td>{{ $update->status }}</td>
                                                        <td>{{ $update->remark }}</td>
                                                        <td>{{ $update->user->name }}</td>
                                                        <td>{{ $update->manual_updated_at }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="footer">
                                        <hr>
                                        <a href="{{ route('admin.activity.download') }}" class="btn btn-primary">
                                            <i class="fa fa-download"></i> Download Report
                                        </a>
                                    </div>

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

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#activitiesTable').DataTable();
        });
    </script>
</body>

</html>
