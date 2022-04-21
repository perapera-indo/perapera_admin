<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ getImageUserLogin() }}">
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    {{--<span class="font-weight-bold mb-2">David Grey. H</span>--}}
                    <span class="font-weight-bold mb-2">{{ ucwords(user_info('first_name'). " ".user_info('last_name')) }}</span>
                    <span class="text-secondary text-small">{{ user_info('role') }}</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        {{--{{dd(config('menu'))}}--}}
        {{--<li class="nav-item {{ setMenuActive('dashboard') }}">--}}
            {{--<a class="nav-link" href="{{ route('dashboard') }}">--}}
                {{--<span class="menu-title">Dashboard</span>--}}
                {{--<i class="mdi mdi-home menu-icon"></i>--}}
            {{--</a>--}}
        {{--</li>--}}

        {{--@isPermitted('user.index')--}}
        {{--<li class="nav-item {{ setMenuActive('user.index') }}">--}}
            {{--<a class="nav-link" href="{{ route('user.index') }}">--}}
                {{--<span class="menu-title">Users</span>--}}
                {{--<i class="mdi mdi-account-multiple-outline menu-icon"></i>--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--@endisPermitted--}}

        {{--@isPermitted('role.index')--}}
        {{--<li class="nav-item {{ setMenuActive('role.index') }}">--}}
            {{--<a class="nav-link" href="{{ route('role.index') }}">--}}
                {{--<span class="menu-title">Roles</span>--}}
                {{--<i class="mdi mdi-account-multiple-outline menu-icon"></i>--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--@endisPermitted--}}

        {{--@isPermitted('role.index')--}}
        {{--<li class="nav-item {{ setMenuActive('permission.index') }}">--}}
            {{--<a class="nav-link" href="{{ route('permission.index') }}">--}}
                {{--<span class="menu-title">Role Permission</span>--}}
                {{--<i class="mdi mdi-account-multiple-outline menu-icon"></i>--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--@endisPermitted--}}
        @forelse(config('menu') as $key => $menu)
            @isPermitted($menu['routeName'])
            <li class="nav-item {{ setMenuActive($menu['routeName']) }}">
                <a class="nav-link"
                   {{ isset($menu['sub_menu']) ? 'data-toggle=collapse href=#'.delimiterToCamelCase($menu['routeName']).' aria-expanded=false aria-controls='.delimiterToCamelCase($menu['routeName']) : '' }}
                    href="{{ isset($menu['sub_menu']) ? '#' : route($menu['routeName']) }}{{ isset($menu['additional_query']) ? $menu['additional_query'] : '' }}">
                    <span class="menu-title">{{ $menu['title'] }}</span>
                    @if(isset($menu['sub_menu']))
                        <i class="menu-arrow"></i>
                    @endif
                    <i class="{{ $menu['icon'] }}"></i>
                </a>
                @if(isset($menu['sub_menu']))
                    <div class="collapse" id="{{delimiterToCamelCase($menu['routeName'])}}">
                    <ul class="nav flex-column sub-menu">
                        @foreach($menu['sub_menu'] as $subKey => $subMenu)
                            @isPermitted($subMenu['routeName'])
                            <li class="nav-item {{ setMenuActive($menu['routeName']) }}">
                                {{-- {{dump(@$subMenu['cid'] ? route($subMenu['routeName'],$subMenu['cid']) : route($subMenu['routeName']))}} --}}
                                <a class="nav-link {{ setMenuActive($subMenu['routeName']) }}" href="{{ @$subMenu['cid'] ? route($subMenu['routeName'],$subMenu['cid']) : route($subMenu['routeName']) }}{{ (@$subMenu['param'] ? '/'.@$subMenu['param'] : '') }}">
                                    {{ $subMenu['title'] }}
                                    {{--@if(@$subMenu['icon'] != null)--}}
                                        {{--<i class="{{ $subMenu['icon'] }}"></i>--}}
                                    {{--@endif--}}
                                </a>
                            </li>
                            @endisPermitted
                            {{-- {{dump(@$subMenu['cid'] ? route($subMenu['routeName'],$subMenu['cid']) : route($subMenu['routeName']))}} --}}
                        @endforeach
                    </ul>
                    </div>
                @endif
            </li>
            @endisPermitted
        @empty

        @endforelse

    </ul>
</nav>
