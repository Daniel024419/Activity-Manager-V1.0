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
                                    @include('dashboard.alerts.alert')
                                    <h4 class="title">Users ({{ count($users) }})</h4>

                                    <span>

                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#userModel">
                                            Add New User
                                        </button>

                                        <a href="{{ route('admin.dashboard.export.admins') }}" class="btn btn-primary">
                                            <i class="fa fa-download"></i> Export Admins
                                        </a>

                                        <a href="{{ route('admin.dashboard.export.users') }}" class="btn btn-primary">
                                            <i class="fa fa-download"></i> Export Users
                                        </a>
                                    </span>
                                </div>
                                <div style="padding: 30px" class="content table-responsive table-full-width">
                                    <table id="usersTable" class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $key => $user)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ Str::ucfirst($user->name) }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->role->name ?? 'N/A' }}</td>
                                                    <td>{{ $user->createdByUser ? Str::ucfirst($user->createdByUser->name) : 'N/A' }}</td>
                                                    <td>{{ $user->created_at }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-primary">Edit</a>
                                                        <a href="{{ route('admin.dashboard.delete.user', $user->id) }}" onclick="return confirmDelete(event);"
                                                            class="btn btn-danger">Delete</a>
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

    <div class="modal fade" id="userModel" tabindex="-1" role="dialog" aria-labelledby="userModelLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModelLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.dashboard.create.user') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <!-- Name Input -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <!-- Email Input -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <!-- Password Input -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <!-- Role Dropdown -->
                        <div class="form-group">
                            <label for="role_id">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="" disabled selected>Select a role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ Str::ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>
