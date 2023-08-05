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
          <!-- Page -->
          <li class="menu-item {{ request()->is('customer*') ? 'active' : '' }}">
            <a href="{{ route('customer.index') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-home-circle"></i>
              <div data-i18n="Customer">Customer</div>
            </a>
          </li>
          <li class="menu-item {{ request()->is('contact*') ? 'active' : '' }}">
            <a href="{{ route('contact.index') }}" class="menu-link">
              <i class="menu-icon tf-icons fa fa-file-alt"></i>
              <div data-i18n="Contact">Contact</div>
            </a>
          </li>
          {{-- <li class="menu-item">
            <a href="page-2.html" class="menu-link">
              <i class="menu-icon tf-icons bx bx-detail"></i>
              <div data-i18n="Sales Invoice">Sales Invoice</div>
            </a>
          </li> --}}
          <li class="menu-item {{ request()->is('user*') ? 'active' : '' }}">
            <a href="{{ route('user.index') }}" class="menu-link">
              <i class="menu-icon tf-icons fa fa-user"></i>
              <div data-i18n="User">User</div>
            </a>
          </li>
        </ul>
      </aside>
      <!-- / Menu -->