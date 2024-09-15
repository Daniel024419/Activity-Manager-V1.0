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
    <!-- Bootstrap CSS -->
 </head>

<body>

    <div class="wrapper">
        @include('dashboard.admins.includes.sidebar')
        <div class="main-panel">
            @include('dashboard.admins.includes.topnav')
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Daily SMS Count</h4>
                                    <p class="category">Comparison with Logs</p>
                                </div>
                                <div class="content">
                                    <div id="smsCountChart" class="ct-chart"></div>
                                    <div class="footer">
                                        <div class="stats">
                                            <i class="fa fa-clock-o"></i> Data updated hourly
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Activity Status</h4>
                                    <p class="category">Current Updates and Remarks</p>
                                </div>
                                <div class="content">
                                    <div id="activityStatus" class="ct-chart"></div>
                                    <div class="footer">
                                        <div class="legend">
                                            <i class="fa fa-circle text-info"></i> Done
                                            <i class="fa fa-circle text-danger"></i> Pending
                                        </div>
                                        <hr>
                                        <div class="stats">
                                            <i class="fa fa-history"></i> Last update 5 minutes ago
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Activity Log</h4>
                                    <p class="category">Daily Updates and Remarks</p>
                                </div>
                                <div class="content">
                                    <div class="table-full-width">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Activity</th>
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
                                                            <td>{{ $activity->description }}</td>
                                                            <td style="color: {{ $update->status === 'done' ? 'green' : 'black' }}">{{ ucfirst($update->status) }}</td>
                                                            <td>{{ $update->remark }}</td>
                                                            <td>{{ $update->user->name }}</td>
                                                            <td>{{ $update->manual_updated_at }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="footer">
                                        <hr>
                                        <div class="stats">
                                            <i class="fa fa-history"></i> Updated just now
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Reports</h4>
                                    <p class="category">Custom Activity Histories</p>
                                </div>
                                <div class="content">
                                    <div id="reportView" class="ct-chart"></div>
                                    <div class="footer">
                                        <div class="stats">
                                            <i class="fa fa-calendar"></i> Custom date range selected
                                        </div>
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
    <!-- Bootstrap JS -->
    <!-- Chartist JS -->
    <script src="https://cdn.jsdelivr.net/npm/chartist/dist/chartist.min.js"></script>
    <script>
        // Data for charts from the controller
        var smsCounts = @json($smsCounts);
        var activityStatus = @json($activityStatus);
        var reports = @json($reports);

        // Initialize SMS Count Chart
        new Chartist.Line('#smsCountChart', {
            labels: smsCounts.labels,
            series: smsCounts.series
        });

        // Initialize Activity Status Chart
        new Chartist.Line('#activityStatus', {
            labels: activityStatus.labels,
            series: activityStatus.series
        });

        // Initialize Reports Chart
        new Chartist.Line('#reportView', {
            labels: reports.labels,
            series: reports.series
        });
    </script>
</body>

</html>
