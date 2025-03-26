<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html">InternPro</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html">STI</a>
    </div>
    <ul class="sidebar-menu">
        @section('sidebar')
            @if (auth()->user()->can('dashboard-access'))
              <li class="menu-header">Dashboard</li>
              <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
            @endif

            @if (auth()->user()->can('major-list'))
              <li class="menu-header">Master Data</li>
              <li class="{{ request()->routeIs('majors.*') ? 'active' : '' }}"><a href="{{ route('majors.index') }}" class="nav-link"><i class="fas fa-save"></i><span>Majors</span></a></li>
            @endif

            @if (auth()->user()->can('permission-list') || auth()->user()->can('role-list') || auth()->user()->can('user-list') || auth()->user()->can('membership-list') || auth()->user()->can('school-list') || auth()->user()->can('dashboard-system'))
              <li class="menu-header">Settings</li>
              @if (auth()->user()->can('dashboard-system'))
                <li class="{{ request()->routeIs('admin-dashboard')  ? 'active' : '' }}"><a href="{{ route('admin-dashboard') }}" class="nav-link"><i class="fas fa-chart-line"></i><span>Admin Dashboard</span></a></li>
              @endif
              @if (auth()->user()->can('membership-list'))
                <li class="{{ request()->routeIs('memberships.*')  ? 'active' : '' }}"><a href="{{ route('memberships.index') }}" class="nav-link"><i class="fas fa-money-check-alt"></i><span>Membership</span></a></li>
              @endif
              @if (auth()->user()->can('school-list'))
                <li class="{{ request()->routeIs('schools.*')  ? 'active' : '' }}"><a href="{{ route('schools.index') }}" class="nav-link"><i class="fas fa-building"></i><span>Schools</span></a></li>
              @endif
              @if (auth()->user()->can('user-list'))
                <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}"><a href="{{ route('users.index') }}" class="nav-link"><i class="fas fa-users"></i><span>User Management</span></a></li>
              @endif

            <li class="nav-item dropdown {{ request()->routeIs('access-control.*') ? 'active' : '' }}">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Access Control</span></a>
              <ul class="dropdown-menu">
              <li class="{{ request()->routeIs('access-control.user-to-role-index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('access-control.user-to-role-index') }}">User Roles</a></li>
              <li class="{{ request()->routeIs('access-control.role-index') || request()->routeIs('access-control.role-show') || request()->routeIs('access-control.role-update') ? 'active' : '' }}"><a class="nav-link" href="{{ route('access-control.role-index') }}">Roles Permissions</a></li>
              <li class="{{ request()->routeIs('access-control.permission-index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('access-control.permission-index') }}">Permissions Management</a></li>
              </ul>
            </li>
            @endif
        @show
      </ul>
  </aside>