 <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">
     <div class="sidebar-wrapper">
         <div class="logo">
             <a href="{{ route('admin.dashboard.home') }}" class="simple-text">
                 Activity Tracker
             </a>
         </div>

         <ul class="nav">
             <li class="active">
                 <a href="{{ route('admin.dashboard.home') }}">
                     <i class="fa fa-home"></i>
                     <p>Dashboard</p>
                 </a>
             </li>

             <li>
                 <a href="{{ route('admin.activity.dashboard.home') }}">
                     <i class="fa fa-tasks"></i>
                     <p>Activity List</p>
                 </a>
             </li>

             <li>
                 <a href="{{ route('admin.dashboard.users') }}">
                     <i class="fa fa-users"></i>
                     <p>Users</p>
                 </a>
             </li>
             <li>
                 <a href="{{ route('admin.dashboard.profile.index') }}">
                     <i class="fa fa-user"></i>
                     <p>User Profile</p>
                 </a>
             </li>
         </ul>
     </div>
 </div>
