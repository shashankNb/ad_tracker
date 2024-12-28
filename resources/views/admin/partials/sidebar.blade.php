<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>{{ auth()->user()->name }}</p>
            <!-- Status -->
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>

    <!-- search form (Optional) -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
    </form>
    <!-- /.search form -->

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">HEADER</li>
        <!-- Optionally, you can add icons to the links -->
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="treeview active">
            <a href="#"><i class="fa fa-globe"></i> <span>Networks</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('networks.add') }}">Networks</a></li>
                <li><a href="{{ route('networks.index') }}">Manage Networks</a></li>
            </ul>
        </li>
        <li class="treeview active">
            <a href="#"><i class="fa fa-link"></i> <span>Link Manager</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('trackingLinks.add') }}">Tracking Links</a></li>
                <li><a href="{{ route('trackingLinks.index') }}">Manage Tracking Links</a></li>
                <li><a href="{{ route('link_groups.add') }}">Link Group</a></li>
                <li><a href="{{ route('link_groups.index') }}">Manage Link Group</a></li>
                <li><a href="{{ route('links.add') }}">Links</a></li>
                <li><a href="{{ route('links.index') }}">Manage Links</a></li>
            </ul>
        </li>
        <li><a href="{{ route('linkStats.index') }}"><i class="fa fa-file-excel-o"></i> <span>Link Reports</span></a></li>
        <li><a href="{{ route('linkStats.index') }}"><i class="fa fa-file-excel-o"></i> <span>Sales Imports</span></a></li>
        <li class="treeview active">
            <a href="#"><i class="fa fa-users"></i> <span>Users</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('users.add') }}">Users</a></li>
                <li><a href="{{ route('users.index') }}">Manage Users</a></li>
            </ul>
        </li>
    </ul>
    <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
