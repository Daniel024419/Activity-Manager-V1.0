<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Activities Tracker | Profile</title>

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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                @include('dashboard.alerts.alert')
                                <h4 class="title">Edit Profile</h4>
                            </div>
                            <div class="content">
                              <form method="POST" autocomplete="false" action="{{ route('users.dashboard.profile.update') }}"
                                        enctype="multipart/form-data" method="POST">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="Name" value="{{ Auth::guard('users')->user()->name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" name="email"
                                                        placeholder="Email" value="{{ Auth::guard('users')->user()->email }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Password">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Role</label>
                                                    <input type="role" class="form-control" readonly disabled
                                                        name="" value="{{ Auth::guard('users')->user()->role->name }}"
                                                        id="">
                                                </div>
                                            </div>

                                            <input type="hidden" class="form-control" name="user_id"
                                                value="{{ Auth::guard('users')->user()->id }}" id="">

                                        </div>

                                        <button type="submit" class="btn btn-info btn-fill pull-right">Update
                                            Profile</button>
                                        <div class="clearfix"></div>
                                    </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-user">
                            <div class="image">
                                <img src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&fm=jpg&h=300&q=75&w=400" alt="..."/>
                            </div>
                            <hr>
                            <div class="text-center">
                                <button href="#" class="btn btn-simple"><i class="fa fa-facebook-square"></i></button>
                                <button href="#" class="btn btn-simple"><i class="fa fa-twitter"></i></button>
                                <button href="#" class="btn btn-simple"><i class="fa fa-google-plus-square"></i></button>

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
