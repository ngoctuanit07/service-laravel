<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{asset('backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">John Nguyen System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('backend/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }} </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            @role('admin')
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            {{ __('app.User') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- <li class="nav-item">
                            <a href="pages/examples/login.html" class="nav-link">
                                <i class="fas fa-user-plus nav-icon"></i>
                                <p>Add user</p>
                            </a>
                        </li> --}}
                        <li class="nav-item has-treeview">
                            <a href="{{ route('profile.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p> {{ __('app.Profile') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>List user</p>
                            </a>

                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>

                                <p> {{ __('app.Logout') }}</p>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>
                           {{ __('app.Role') }} 
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">

                            <a href="{{ route('roles.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>  {{ __('app.ListRole') }} </p>
                            </a>


                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>
                            {{ __('app.Proxy') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                
                            <a href="{{ route('proxy.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p> {{ __('app.ListProxy') }} </p>
                            </a>
                
                
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>
                           {{ __('app.Trackingkeyword') }} 
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('configtracking.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>  {{ __('app.ConfigTrackingManagement') }} </p>
                            </a>
                            <a href="{{ route('tracking.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>  {{ __('app.ReportRankKeyword') }} </p>
                            </a>


                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>
                            {{ __('app.Permission') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('permission.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>  {{ __('app.ListPermission') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>
                             {{ __('app.Crawdata') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('config.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>   {{ __('app.ConfigCrawAuto') }}</p>
                            </a>
                            <a href="{{ route('craw.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p> {{ __('app.ListCrawData') }}</p>
                            </a>
                            <a href="{{ route('crawcat.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>{{ __('app.CrawCatData') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="nav-item has-treeview">
                    <a href="{{ route('document.index') }}" class="nav-link">
                        <i class="fas fa-list-ul nav-icon"></i>
                        <p>Document setup tool</p>
                    </a>
                </li> --}}
            </ul>
            @endrole
            @role('user')
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                           {{ __('app.User') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- <li class="nav-item">
                            <a href="pages/examples/login.html" class="nav-link">
                                <i class="fas fa-user-plus nav-icon"></i>
                                <p>Add user</p>
                            </a>
                        </li> --}}

                        <li class="nav-item has-treeview">
                            <a href="{{ route('profile.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>   {{ __('app.Profile') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>

                                <p> {{ __('app.Logout') }}</p>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>

                    </ul>
                </li>
                
                {{-- <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>
                            Craw
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('craw.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>List Craw Data</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>
                           {{ __('app.Trackingkeyword') }} 
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('configtracking.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>  {{ __('app.ConfigTrackingManagement') }} </p>
                            </a>
                            <a href="{{ route('tracking.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>  {{ __('app.ReportRankKeyword') }} </p>
                            </a>


                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>
                             {{ __('app.Crawdata') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('config.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>   {{ __('app.ConfigCrawAuto') }}</p>
                            </a>
                            <a href="{{ route('craw.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p> {{ __('app.ListCrawData') }}</p>
                            </a>
                            <a href="{{ route('crawcat.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>{{ __('app.CrawCatData') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('document.index') }}" class="nav-link">
                        <i class="fas fa-list-ul nav-icon"></i>
                        <p>{{ __('app.Documentsetuptool') }}</p>
                    </a>
                </li>
            </ul>
            @endrole

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
