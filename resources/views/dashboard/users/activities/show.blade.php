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
                                    <h4 class="title">Activity <b> {{ $activities->description }} </b></h4>
                                    <p class="category">Daily Updates and Remarks</p>

                                    <span>

                                        {{-- <a href="{{ route('admin.activity.dashboard.download', $activities->id) }}"
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
                                                <th>Status</th>
                                                <th>Remark</th>
                                                <th>Personnel</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($activities->updates as $update)
                                                <tr>
                                                    <td>{{ $activities->id }}</td>
                                                    <td>{{ $activities->description }}</td>
                                                    <td
                                                        style="color: {{ $update->status === 'done' ? 'green' : 'gold' }}">
                                                        {{ Str::ucfirst($update->status) }}</td>
                                                    <td>{{ $update->remark }}</td>
                                                    <td>{{ $update->user ? $update->user->name : 'N/A' }}</td>
                                                    <td>{{ $update->manual_updated_at }}</td>
                                                    <td>
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

    @include('dashboard.users.includes.script')
    <!-- Modal for adding a new activity -->
</body>

</html>
