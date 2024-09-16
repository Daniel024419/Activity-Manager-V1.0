<nav class="navbar navbar-default navbar-fixed">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Dashboard</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-dashboard"></i>
                        <p class="hidden-lg hidden-md">Dashboard</p>
                    </a>
                </li>
                 <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-globe"></i>
                        <b class="caret hidden-lg hidden-md"></b>
                        <p class="hidden-lg hidden-md">
                            {{$notifications ? count($notifications) : 0}} Notifications
                            <b class="caret"></b>
                        </p>
                    </a>
                    <ul class="dropdown-menu" style="overflow-y: auto; max-height: 300px;">

                        @if ($notifications)
                            @foreach ($notifications as $notification)
                                <li> <a href="#">{{ $notification->action }} at {{ $notification->created_at }}
                                     <span>By  : {{ $notification->createdByUser ? Str::ucfirst($notification->createdByUser->name) : 'N/A' }} </span>
                                    </li></a>
                                    <hr>

                            @endforeach
                        @endif

                    </ul>
                </li>
                <li>
                    <a href="">
                        <i class="fa fa-search"></i>
                        <p class="hidden-lg hidden-md">Search</p>
                    </a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">

                <!-- User Info Dropdown -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <p>
                            <!-- Display User's Project Image and Name -->
                            <img src="{{ asset('img/default-avatar.png') }}" alt="Project Image" class="img-circle"
                                width="30" height="30">
                            {{ isset(auth()->user()->name) ? auth()->user()->name : 'N/A' }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <ul class="dropdown-menu">
                        <li> <a href="{{ route('admin.dashboard.profile.index') }}">
                                <p>Account</p>
                            </a></li>

                        <li class="divider"></li>

                        <li>
                            <a href="{{ route('auth.adminLogout') }}" onclick="return confirmLogout(event);">
                                <p>Log out</p>
                            </a>
                        </li>


                    </ul>
                </li>

                <li class="separator hidden-lg"></li>
            </ul>

        </div>
    </div>
</nav>
