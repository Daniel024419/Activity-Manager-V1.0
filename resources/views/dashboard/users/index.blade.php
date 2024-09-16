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

</head>

<body>

    <div class="wrapper">

        @include('dashboard.users.includes.sidebar')
        <div class="main-panel">
            @include('dashboard.users.includes.topnav')
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Total Activities</h4>
                                    <p class="category">Activities You've Updated</p>
                                </div>
                                <div class="content">
                                    <h3>{{ $totalActivities }}</h3>
                                    <div class="footer">
                                        <div class="stats">
                                            <i class="fa fa-clock-o"></i> Updated just now
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Done Activities</h4>
                                    <p class="category">Completed Tasks</p>
                                </div>
                                <div class="content">
                                    <h3>{{ $doneActivities }}</h3>
                                    <div class="footer">
                                        <div class="stats">
                                            <i class="fa fa-clock-o"></i> Updated just now
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Pending Activities</h4>
                                    <p class="category">Tasks Pending Completion</p>
                                </div>
                                <div class="content">
                                    <h3>{{ $pendingActivities }}</h3>
                                    <div class="footer">
                                        <div class="stats">
                                            <i class="fa fa-clock-o"></i> Updated just now
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Activity Updates by Day</h4>
                                    <p class="category">Daily Updates Overview</p>
                                </div>
                                <div class="content">
                                    <div id="smsCountChart" class="ct-chart"></div>
                                    <div class="footer">
                                        <div class="stats">
                                            <i class="fa fa-history"></i> Last updated just now
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                new Chartist.Line('#smsCountChart', {
                    labels: @json(array_keys($smsCounts->toArray())),
                    series: [@json(array_values($smsCounts->toArray()))]
                });
            </script>



            @include('dashboard.admins.includes.footer')

        </div>
    </div>
    @include('dashboard.admins.includes.script')
</body>
<script type="text/javascript">
    $(document).ready(function(){
        demo.initChartist();

        $.notify({
            icon: 'pe-7s-gift',
            message: "Welcome Back <b>User</b> "

        },{
            type: 'info',
            timer: 3000
        });
    });
</script>
</html>
