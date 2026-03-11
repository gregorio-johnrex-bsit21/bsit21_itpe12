<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>


    <li class="nav-item {{ request()->routeIs('admin.students') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.students') }}">
        <i class="menu-icon mdi mdi-floor-plan"></i>
        <span class="menu-title">Students</span>
      </a>
    </li>


    <li class="nav-item {{ request()->routeIs('admin.supervisor') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.supervisor') }}">
        <i class="menu-icon mdi mdi-floor-plan"></i>
        <span class="menu-title">Supervisor</span>
      </a>
    </li>

  
    
   
  </ul>
</nav>
