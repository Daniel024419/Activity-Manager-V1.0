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

        @include('dashboard.admins.includes.sidebar')
        <div class="main-panel">
            @include('dashboard.admins.includes.topnav')
            <div class="content">
                <div class="container-fluid">
                   

                   
                </div>
            </div>


            @include('dashboard.admins.includes.footer')

        </div>
    </div>
    @include('dashboard.admins.includes.script')
</body>

</html>
