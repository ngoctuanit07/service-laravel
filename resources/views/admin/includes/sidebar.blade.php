<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
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
                            User
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

                                <p> {{ __('Logout') }}</p>
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
                            Role
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">

                            <a href="{{ route('roles.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>List Role</p>
                            </a>


                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>
                            Permission
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('permission.index') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>List Permission</p>
                            </a>
                        </li>
                    </ul>
                </li>
                 <li class="nav-item has-treeview">
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
                </li>
            </ul>
            @endrole

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
