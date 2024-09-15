<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Activities Tracker | Users </title>

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
                                    <h4 class="title">Users List</h4>
                                </div>
                                <div class="content table-responsive table-full-width">
                                    <table id="usersTable" class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->id }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->role->name ?? 'N/A' }}</td>
                                                    <td>{{ $user->createdByUser->name ?? 'N/A' }}</td>
                                                    <td>{{ $user->created_at }}</td>
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

</body>

</html>
