<!-- Logo -->
<a href="#" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>A</b>LT</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Admin</b>LTE</span>
</a>

<!-- Header Navbar -->
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <!-- /.messages-menu -->
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <!-- The user image in the navbar-->
                    <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                    <span class="hidden-xs">{{ auth()->user()->name }}</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- The user image in the menu -->
                    <li class="user-header">
                        <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

                        <p>
                            {{ auth()->user()->name }} - Web Developer
                            <small>Member <since></since> Nov. 2012</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-right">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="btn btn-default btn-flat" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">Log Out</a>
                            </form>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
