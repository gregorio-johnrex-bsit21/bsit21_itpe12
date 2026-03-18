<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>


    <li class="nav-item {{ request()->routeIs('admin.supervisor') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.supervisor') }}">
        <i class="menu-icon mdi mdi-office-building"></i>
        <span class="menu-title">Company</span>
      </a>
    </li>


    <li class="nav-item {{ request()->routeIs('admin.students') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.students') }}">
        <i class="menu-icon mdi mdi-account-group"></i>
        <span class="menu-title">Student Attendance</span>
      </a>
    </li>

        <li class="nav-item {{ request()->routeIs('admin.report') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.report') }}">
        <i class="menu-icon mdi mdi-file-chart"></i>
        <span class="menu-title">Report</span>
      </a>
    </li>

  
    
   
  </ul>
</nav>
