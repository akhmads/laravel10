      <!-- Menu -->
      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="{{ url('/admin') }}" class="app-brand-link">
              <img src="{{ url('assets/img/logo.svg') }}" alt="Hypercode" style="height:50px;">
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">

          @include('admin.menu.menu')

          @can('admin')
          <li class="menu-item {{ request()->routeIs('system*') ? 'active open' : '' }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons fa fa-cog"></i>
              <div data-i18n="System">System</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/user') ? 'active' : '' }}">
                  <a href="{{ url('admin/user') }}" class="menu-link">
                    <div data-i18n="User">User</div>
                  </a>
                </li>
                <li class="menu-item {{ request()->is('admin/menu-manager') ? 'active' : '' }}">
                  <a href="{{ url('admin/menu-manager') }}" class="menu-link">
                    <div data-i18n="Menu Manager">Menu Manager</div>
                  </a>
                </li>
              </ul>
          </li>
          @endcan

        </ul>
      </aside>
      <!-- / Menu -->
