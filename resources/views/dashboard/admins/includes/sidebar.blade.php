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
                     <i class="pe-7s-graph"></i>
                     <p>Dashboard</p>
                 </a>
             </li>

             <li>
                 <a href="{{ route('admin.activity.dashboard.home') }}">
                     <i class="pe-7s-note2"></i>
                     <p>Activity List</p>
                 </a>
             </li>

             <li>
                 <a href="{{ route('admin.dashboard.users') }}">
                     <i class="pe-7s-user"></i>
                     <p>Users</p>
                 </a>
             </li>
             <li>
                 <a href="{{ route('admin.dashboard.profile.index') }}">
                     <i class="pe-7s-user"></i>
                     <p>User Profile</p>
                 </a>
             </li>
         </ul>
     </div>
 </div>
