<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item nav-category">UI Elements</li>

    <li class="nav-item {{ request()->is('ui-elements*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="menu-icon mdi mdi-floor-plan"></i>
        <span class="menu-title">UI Elements</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->is('ui-elements*') ? 'show' : '' }}" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="/pages/ui-features/buttons.html">Buttons</a></li>
          <li class="nav-item"><a class="nav-link" href="/pages/ui-features/dropdowns.html">Dropdowns</a></li>
          <li class="nav-item"><a class="nav-link" href="/pages/ui-features/typography.html">Typography</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item {{ request()->is('forms*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
        <i class="menu-icon mdi mdi-card-text-outline"></i>
        <span class="menu-title">Form Elements</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->is('forms*') ? 'show' : '' }}" id="form-elements">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="/pages/forms/basic_elements.html">Basic Elements</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item {{ request()->is('charts*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
        <i class="menu-icon mdi mdi-chart-line"></i>
        <span class="menu-title">Charts</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->is('charts*') ? 'show' : '' }}" id="charts">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="/pages/charts/chartjs.html">ChartJs</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item {{ request()->is('tables*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
        <i class="menu-icon mdi mdi-table"></i>
        <span class="menu-title">Tables</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->is('tables*') ? 'show' : '' }}" id="tables">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="/pages/tables/basic-table.html">Basic Table</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item {{ request()->is('icons*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
        <i class="menu-icon mdi mdi-layers-outline"></i>
        <span class="menu-title">Icons</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->is('icons*') ? 'show' : '' }}" id="icons">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="/pages/icons/font-awesome.html">Font Awesome</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item {{ request()->is('user-pages*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
        <i class="menu-icon mdi mdi-account-circle-outline"></i>
        <span class="menu-title">User Pages</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->is('user-pages*') ? 'show' : '' }}" id="auth">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="#">Blank Page</a></li>
          <li class="nav-item"><a class="nav-link" href="#">404</a></li>
          <li class="nav-item"><a class="nav-link" href="#">500</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Register</a></li>
        </ul>
      </div>
    </li>

 

  </ul>
</nav>
