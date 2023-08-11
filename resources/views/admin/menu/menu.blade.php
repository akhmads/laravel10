
    @inject('menus', 'App\Models\Menu')

    @foreach($menus::where('parent_id','=','0')->orderBy('ord','asc')->get() as $menu)
    @if(count($menu->childs)>0)
    <li class="menu-item {{ request()->routeIs($menu->scope) ? 'active open' : '' }}">
    @else
    <li class="menu-item {{ request()->is($menu->url) ? 'active' : '' }}">
    @endif
        <a href="{!! count($menu->childs)>0 ? 'javascript:void(0)' : url($menu->url) !!}" class="menu-link {{ count($menu->childs)>0 ? 'menu-toggle' : '' }}">
          <i class="menu-icon tf-icons {{ $menu->icon }}"></i>
          <div>{{ $menu->title }}</div>
        </a>
        @if(count($menu->childs)>0)
        <ul class="menu-sub">
            @include('admin.menu.child',['menus' => $menu->childs])
        </ul>
        @endif
    </li>
    @endforeach
